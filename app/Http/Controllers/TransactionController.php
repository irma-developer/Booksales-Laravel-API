<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'book'])->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Get all transactions',
            'data'    => $transactions
        ], 200);
    }

    public function show(Request $request, string $id)
    {
        $trx = Transaction::with(['user', 'book'])->find($id);
        if (!$trx) {
            return response()->json(['success' => false, 'message' => 'Transaction not found', 'data' => null], 404);
        }
        $user = $request->user();
        if ($user->role !== 'admin' && $trx->customer_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Forbidden', 'data' => null], 403);
        }
        return response()->json(['success' => true, 'message' => 'Get transaction detail', 'data' => $trx], 200);
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'book_id'  => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);
        if ($v->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation Error', 'data' => $v->errors()], 422);
        }

        $user = $request->user();

        try {
            $result = DB::transaction(function () use ($request, $user) {
                $book = Book::lockForUpdate()->find($request->book_id);
                if (!$book) {
                    return ['error' => true, 'resp' => response()->json(['success' => false, 'message' => 'Book not found', 'data' => null], 404)];
                }
                if ($book->stock < $request->quantity) {
                    return ['error' => true, 'resp' => response()->json(['success' => false, 'message' => 'Insufficient book stock', 'data' => null], 400)];
                }

                $book->decrement('stock', $request->quantity);
                $amount = $book->price * $request->quantity;

                $trx = Transaction::create([
                    'order_number' => 'ORD-' . Str::upper(Str::random(10)),
                    'customer_id'  => $user->id,
                    'book_id'      => $book->id,
                    'quantity'     => $request->quantity,
                    'total_amount' => $amount,
                ]);

                return ['error' => false, 'trx' => $trx];
            });

            if ($result['error'] ?? false) {
                return $result['resp'];
            }

            return response()->json([
                'success' => true,
                'message' => 'Transaction created successfully',
                'data'   => $result['trx']->load(['user', 'book'])
            ], 201);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Server error', 'data' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $v = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
        ]);
        if ($v->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation Error', 'data' => $v->errors()], 422);
        }

        $trx = Transaction::find($id);
        if (!$trx) {
            return response()->json(['success' => false, 'message' => 'Transaction not found', 'data' => null], 404);
        }

        $user = $request->user();
        if ($trx->customer_id !== $user->id && $user->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Forbidden', 'data' => null], 403);
        }

        try {
            DB::transaction(function () use ($request, $trx) {
                $book = Book::lockForUpdate()->find($trx->book_id);
                $delta = $request->quantity - $trx->quantity;

                if ($delta > 0 && $book->stock < $delta) {
                    abort(response()->json(['success' => false, 'message' => 'Insufficient book stock', 'data' => null], 400));
                }

                if ($delta > 0) {
                    $book->decrement('stock', $delta);
                } elseif ($delta < 0) {
                    $book->increment('stock', abs($delta));
                }

                $trx->quantity     = $request->quantity;
                $trx->total_amount = $book->price * $request->quantity;
                $trx->save();
            });

            return response()->json(['success' => true, 'message' => 'Transaction updated', 'data' => $trx->fresh()->load(['user', 'book'])], 200);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Server error', 'data' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        $trx = Transaction::find($id);
        if (!$trx) {
            return response()->json(['success' => false, 'message' => 'Transaction not found', 'data' => null], 404);
        }
        $trx->delete();
        return response()->json(['success' => true, 'message' => 'Transaction deleted', 'data' => null], 200);
    }
}

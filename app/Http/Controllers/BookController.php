<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['author:id,name', 'genre:id,name'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Get all resources',
            'data'    => $books
        ], 200);
    }

    public function store(Request $request)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'title'          => 'required|string|max:255',
            'author_id'      => 'required|integer|exists:authors,id',
            'genre_id'       => 'required|integer|exists:genres,id',
            'published_year' => 'required|integer',
            'price'          => 'required|integer',
            'description'    => 'required|string',
            'stock'          => 'required|integer',
            'cover_photo'    => 'required|file|mimes:jpg,jpeg|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'data'    => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        if ($request->hasFile('cover_photo')) {
            $ext  = $request->file('cover_photo')->extension();
            $name = Str::uuid() . '.' . $ext;
            $path = $request->file('cover_photo')->storeAs('books', $name, 'public');
            $data['cover_photo'] = $path;
        }

        $book = Book::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Resource added successfully!',
            'data'    => $book
        ], 200);
    }

    // === Pindahkan show() keluar dari store ===
    public function show(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get detail resource',
            'data'    => $book
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        //1 mencari data
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found',
                'data'    => null
            ], 404);
        }
        //2 validasi
        $validator = Validator::make($request->all(), [
            'title'          => 'required|string|max:255',
            'author_id'      => 'required|integer|exists:authors,id',
            'genre_id'       => 'required|integer|exists:genres,id',
            'published_year' => 'required|integer',
            'price'          => 'required|integer',
            'description'    => 'required|string',
            'stock'          => 'required|integer',
            'cover_photo'    => 'nullable|file|mimes:jpg,jpeg|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'data'    => $validator->errors(),
            ], 422);
        }

        //3 siapkan data yang ingin di update
        $data = [
            'title'          => $request->title,
            'author_id'      => $request->author_id,
            'genre_id'       => $request->genre_id,
            'published_year' => $request->published_year,
            'price'          => $request->price,
            'description'    => $request->description,
            'stock'          => $request->stock,
        ];

        // 4. handle image (upload & delete image)
        if ($request->hasFile('cover_photo')) {
            $image = $request->file('cover_photo');
            $image->store('books', 'public');

            if ($book->cover_photo) {
                Storage::disk('public')->delete('books/' . $book->cover_photo);
            }

            $data['cover_photo'] = $image->hashName();
        }


        //5 update data
        $book->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Resource updated successfully!',
            'data'    => $book
        ], 200);
    }

    public function destroy(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found',
                'data'    => null
            ], 404);
        }

        if ($book->cover_photo) {
            // delete from storage
            Storage::disk('public')->delete('books/' . $book->cover_photo);
        }


        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Resource deleted successfully!',
            'data'    => null
        ], 200);
    }
}

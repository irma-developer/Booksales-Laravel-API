<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    // GET /api/authors
    public function index()
    {
        // kalau mau ikut jumlah buku: Author::withCount('books')->orderBy('name')->get();
        $authors = Author::orderBy('name')->get();

        return response()->json([
            'success' => true,
            'message' => 'Get all authors',
            'data'    => $authors,
        ], 200);
    }

    // POST /api/authors
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150|unique:authors,name',
            'bio'  => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'data'    => $validator->errors(),
            ], 422);
        }

        $author = Author::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Author created',
            'data'    => $author,
        ], 201);
    }
}

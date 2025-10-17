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

    // GET /api/authors/{id}
    public function show(string $id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Author not found',
                'data'    => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get author detail',
            'data'    => $author,
        ], 200);
    }

    // PUT/PATCH /api/authors/{id}
    public function update(Request $request, string $id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Author not found',
                'data'    => null,
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            // abaikan unique untuk id yang sedang diupdate
            'name' => 'required|string|max:150|unique:authors,name,' . $author->id,
            'bio'  => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'data'    => $validator->errors(),
            ], 422);
        }

        $author->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Author updated',
            'data'    => $author,
        ], 200);
    }

    // DELETE /api/authors/{id}
    public function destroy(string $id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Author not found',
                'data'    => null,
            ], 404);
        }

        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'Author deleted',
            'data'    => null,
        ], 200);
    }
}

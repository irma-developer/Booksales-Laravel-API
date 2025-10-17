<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    // GET /api/genres
    public function index()
    {
        $genres = Genre::orderBy('name')->get();

        return response()->json([
            'success' => true,
            'message' => 'Get all genres',
            'data'    => $genres,
        ], 200);
    }

    // POST /api/genres
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:100|unique:genres,name',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'data'    => $validator->errors(),
            ], 422);
        }

        $genre = Genre::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Genre created',
            'data'    => $genre,
        ], 201);
    }

    // GET /api/genres/{id}
    public function show(string $id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Genre not found',
                'data'    => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get genre detail',
            'data'    => $genre,
        ], 200);
    }

    // PUT/PATCH /api/genres/{id}
    public function update(Request $request, string $id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Genre not found',
                'data'    => null,
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            // ignore unique untuk id yang sedang diupdate
            'name'        => 'required|string|max:100|unique:genres,name,' . $genre->id,
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'data'    => $validator->errors(),
            ], 422);
        }

        $genre->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Genre updated',
            'data'    => $genre,
        ], 200);
    }

    // DELETE /api/genres/{id}
    public function destroy(string $id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Genre not found',
                'data'    => null,
            ], 404);
        }

        $genre->delete();

        return response()->json([
            'success' => true,
            'message' => 'Genre deleted',
            'data'    => null,
        ], 200);
    }
}

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
}

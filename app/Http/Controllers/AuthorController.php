<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::withCount('books')->orderBy('name')->get();

        return response()->json([
            "success" => true,
            "message" => "Get all authors",
            "data" => $authors
        ], 200);
    }
}

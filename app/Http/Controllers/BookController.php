<?php

namespace App\Http\Controllers;

use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('author')->orderBy('title')->get();

        return response()->json([
            "success" => true,
            "message" => "Get all books",
            "data" => $books
        ], 200);
    }
}

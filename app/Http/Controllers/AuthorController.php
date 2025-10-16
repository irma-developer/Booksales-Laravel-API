<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::withCount('books')->orderBy('name')->get();
        return view('authors.index', compact('authors'));
    }
}

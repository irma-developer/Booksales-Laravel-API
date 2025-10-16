<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all(); // ambil array dari Model
        return view('authors.index', compact('authors'));
    }
}

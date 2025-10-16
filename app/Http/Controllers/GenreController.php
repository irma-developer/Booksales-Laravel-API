<?php

namespace App\Http\Controllers;

use App\Models\Genre;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::all(); // ambil array dari Model
        return view('genres.index', compact('genres'));
    }
}

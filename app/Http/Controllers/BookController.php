<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
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
        // 1) Validasi
        $validator = Validator::make($request->all(), [
            'title'          => 'required|string|max:255',
            'author_id'      => 'required|integer|exists:authors,id',
            'genre_id'       => 'required|integer|exists:genres,id',
            'published_year' => 'required|integer',
            'price'          => 'required|integer',
            'description'    => 'required|string',
            'stock'          => 'required|integer',
            // terima jpg/jpeg max 2MB
            'cover_photo'    => 'required|file|mimes:jpg,jpeg|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'data'    => $validator->errors(),
            ], 422);
        }

        // 2) Ambil data tervalidasi
        $data = $validator->validated();

        // 3) Upload file (WAJIB: Postman body = form-data, key cover_photo = File)
        if ($request->hasFile('cover_photo')) {
            $ext  = $request->file('cover_photo')->extension();      // jpg / jpeg
            $name = Str::uuid().'.'.$ext;                             // nama unik
            $path = $request->file('cover_photo')
                           ->storeAs('books', $name, 'public');       // storage/app/public/books/...
            $data['cover_photo'] = $path;                             // simpan path relatif
        }

        // 4) Simpan ke DB
        $book = Book::create($data);

        // 5) Response
        return response()->json([
            'success' => true,
            'message' => 'Resource added successfully!',
            'data'    => $book
        ], 201);
    }
}

<?php

namespace Database\Seeders;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $fitzId = Author::firstOrCreate(
            ['name' => 'F. Scott Fitzgerald'],
            ['bio'  => 'Penulis Amerika']
        )->id;

        $fictionId = Genre::firstOrCreate(
            ['name' => 'Fiction'],
            ['description' => 'Cerita rekaan/novel']
        )->id;

        $books = [
            [
                'title'          => 'The Great Gatsby',
                'description'    => 'A novel written by American author F. Scott Fitzgerald.',
                'price'          => 15000,
                'stock'          => 30,                    // <-- WAJIB ada
                'genre_id'       => $fictionId,
                'author_id'      => $fitzId,
                'cover_photo'    => 'great_gatsby.jpg',    // <-- WAJIB ada
                'published_year' => 1925,
            ],
            [
                'title'          => 'Tender Is the Night',
                'description'    => 'Novel by F. Scott Fitzgerald.',
                'price'          => 16000,
                'stock'          => 25,
                'genre_id'       => $fictionId,
                'author_id'      => $fitzId,
                'cover_photo'    => 'tender_is_the_night.jpg',
                'published_year' => 1934,
            ],
            [
                'title'          => 'This Side of Paradise',
                'description'    => 'Debut novel by F. Scott Fitzgerald.',
                'price'          => 14000,
                'stock'          => 20,
                'genre_id'       => $fictionId,
                'author_id'      => $fitzId,
                'cover_photo'    => 'this_side_of_paradise.jpg',
                'published_year' => 1920,
            ],
        ];

        foreach ($books as $b) {
            Book::updateOrCreate(['title' => $b['title']], $b);
        }
    }
}

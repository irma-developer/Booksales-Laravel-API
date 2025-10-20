<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AuthorSeeder::class, // author duluan
            GenreSeeder::class,  // lalu genre
            BookSeeder::class,   // terakhir book (butuh author_id & genre_id)
            UserSeeder::class,
        ]);
    }
}

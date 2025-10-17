<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
   public function run(): void
{
    $items = [
        ['name'=>'Fiction',     'description'=>'Cerita rekaan/novel'],
        ['name'=>'Non-Fiction', 'description'=>'Berbasis fakta'],
        ['name'=>'Fantasy',     'description'=>'Dunia imajinatif/magis'],
        ['name'=>'Romance',     'description'=>'Kisah percintaan'],
        ['name'=>'Science',     'description'=>'Sains & pengetahuan'],
    ];

    foreach ($items as $g) {
        \App\Models\Genre::firstOrCreate(['name' => $g['name']], ['description' => $g['description']]);
    }
}
}

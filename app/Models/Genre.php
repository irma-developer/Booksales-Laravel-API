<?php

namespace App\Models;

class Genre
{
    public static function all(): array
    {
        return [
            ['id' => 1, 'name' => 'Fiction',      'description' => 'Cerita rekaan/khayalan'],
            ['id' => 2, 'name' => 'Non-Fiction',  'description' => 'Berbasis fakta & referensi'],
            ['id' => 3, 'name' => 'Science',      'description' => 'Sains & pengetahuan'],
            ['id' => 4, 'name' => 'Romance',      'description' => 'Kisah percintaan'],
            ['id' => 5, 'name' => 'Self-Help',    'description' => 'Pengembangan diri'],
        ];
    }
}

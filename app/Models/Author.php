<?php

namespace App\Models;

class Author
{
    public static function all(): array
    {
        return [
            ['id' => 1, 'name' => 'Andrea Hirata',   'bio' => 'Penulis Indonesia, tetralogi Laskar Pelangi'],
            ['id' => 2, 'name' => 'Tere Liye',       'bio' => 'Penulis fiksi populer dengan tema kehidupan'],
            ['id' => 3, 'name' => 'Dewi Lestari',    'bio' => 'Penulis & musisi, seri Supernova'],
            ['id' => 4, 'name' => 'Agustinus Wibowo','bio' => 'Travel writer & memoir (Selimut Debu, Titik Nol)'],
            ['id' => 5, 'name' => 'Yuval Noah Harari','bio' => 'Sejarawan, Sapiens/Homo Deus'],
        ];
    }
}

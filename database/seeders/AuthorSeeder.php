<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        Author::insert([
            ['name' => 'Andrea Hirata',     'bio' => 'Penulis tetralogi Laskar Pelangi', 'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Tere Liye',         'bio' => 'Penulis fiksi populer',            'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Dewi Lestari',      'bio' => 'Penulis & musisi',                 'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Agustinus Wibowo',  'bio' => 'Travel writer',                    'created_at'=>now(),'updated_at'=>now()],
            ['name' => 'Yuval N. Harari',   'bio' => 'Sejarawan (Sapiens)',              'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}

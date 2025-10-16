<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        // ambil id author biar rapi
        $id = Author::pluck('id','name');

        Book::insert([
            ['title'=>'Laskar Pelangi','author_id'=>$id['Andrea Hirata'],'genre'=>'Fiction','published_year'=>2005,'price'=>85000,'description'=>'Novel ikonik Belitung','created_at'=>now(),'updated_at'=>now()],
            ['title'=>'Bumi','author_id'=>$id['Tere Liye'],'genre'=>'Fantasy','published_year'=>2014,'price'=>78000,'description'=>'Petualangan Raib dkk','created_at'=>now(),'updated_at'=>now()],
            ['title'=>'Supernova: Ksatria, Puteri & Bintang Jatuh','author_id'=>$id['Dewi Lestari'],'genre'=>'Fiction','published_year'=>2001,'price'=>90000,'description'=>'Fiksi filosofis','created_at'=>now(),'updated_at'=>now()],
            ['title'=>'Titik Nol','author_id'=>$id['Agustinus Wibowo'],'genre'=>'Travel/Memoir','published_year'=>2013,'price'=>95000,'description'=>'Perjalanan & pulang','created_at'=>now(),'updated_at'=>now()],
            ['title'=>'Sapiens','author_id'=>$id['Yuval N. Harari'],'genre'=>'Non-Fiction','published_year'=>2011,'price'=>120000,'description'=>'Sejarah singkat umat manusia','created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}

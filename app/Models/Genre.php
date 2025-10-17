<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['name','description'];
    // kalau migration/table kamu beda nama, set manual:
    // protected $table = 'genres';
}

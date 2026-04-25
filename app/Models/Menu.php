<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    // Tambahin ini biar Laravel izinin input data ke kolom-kolom ini
    protected $fillable = [
        'name',
        'description',
        'calories',
        'price'
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distribusi extends Model
{
    protected $fillable = [
        'sekolah_tujuan', 
        'jumlah_porsi', 
        'tanggal_pengiriman', 
        'status', 
        'catatan_kendala'
    ];
}

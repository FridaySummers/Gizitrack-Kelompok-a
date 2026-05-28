<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestChange extends Model
{
    use HasFactory;

    protected $fillable = [
        'distribusi_id',
        'jumlah_porsi_awal',
        'jumlah_porsi_baru',
        'alasan',
    ];

    public function distribusi()
    {
        return $this->belongsTo(Distribusi::class);
    }
}

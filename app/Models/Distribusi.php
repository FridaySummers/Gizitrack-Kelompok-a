<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribusi extends Model
{
    use HasFactory;

    protected $table = "distribusis";

    protected $fillable = [
        "sekolah_tujuan",
        "jumlah_porsi",
        "tanggal_pengiriman",
        "status",
        "catatan_kendala",
    ];

    // Relationships
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, "distribution_id");
    }

    public function requestChanges()
    {
        return $this->hasMany(RequestChange::class);
    }
}

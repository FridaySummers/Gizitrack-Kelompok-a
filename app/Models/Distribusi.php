<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribusi extends Model
{
    use HasFactory;

    protected $table = "distribusis";

    protected $fillable = [
        "sekolah_id",
        "vendor_id",
        "menu_id",
        "sekolah_tujuan",
        "jumlah_porsi",
        "tanggal_pengiriman",
        "status",
        "catatan_kendala",
    ];

    // Relationships
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, "distribusi_id");
    }

    public function requestChanges()
    {
        return $this->hasMany(RequestChange::class, "distribusi_id");
    }

    public function sekolah()
    {
        return $this->belongsTo(User::class, "sekolah_id");
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, "vendor_id");
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, "menu_id");
    }
}

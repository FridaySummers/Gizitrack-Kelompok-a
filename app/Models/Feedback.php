<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = "feedbacks";

    protected $fillable = ["distribusi_id", "user_id", "catatan"];

    public function distribution()
    {
        return $this->belongsTo(Distribusi::class, "distribusi_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}

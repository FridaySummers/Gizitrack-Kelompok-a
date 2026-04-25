<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    
    protected $fillable = ['distribution_id', 'user_id', 'catatan'];

    public function distribution()
    {
        return $this->belongsTo(Distribusi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

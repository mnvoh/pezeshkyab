<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public $fillable = ['doctor_id', 'rating', 'rated_at', 'ip', 'desc', 'name', 'lname', 'ncode'];
    public $timestamps = false;

    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    public $timestamps = false;
    public $fillable = ['doctor_id', 'name', 'symptoms'];

    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor');
    }

    public function reservations()
    {
        return $this->hasMany('App\Models\Reservation');
    }
}

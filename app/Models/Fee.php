<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    public $timestamps = false;
    public $fillable = ['title', 'amount'];

    public function reservations()
    {
        return $this->hasMany('App\Model\Reservation');
    }
}

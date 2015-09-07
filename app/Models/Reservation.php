<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public $timestamps = false;
    public $fillable = ['doctor_id', 'rtime', 'fee_id', 'pname', 'plname', 'nationality', 'ncode', 'pemail'
        , 'disease_id', 'tracking_code'];

    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor');
    }

    public function fee()
    {
        return $this->belongsTo('App\Models\Fee');
    }

    public function disease()
    {
        return $this->belongsTo('App\Models\Disease');
    }
}

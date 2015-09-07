<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;
    public $fillable = ['province_id', 'name'];
    protected $table = 'cities';

    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\Address');
    }
}

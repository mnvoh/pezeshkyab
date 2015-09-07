<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $timestamps = false;

    public $fillable = ['city_id', 'street_addr_1', 'street_addr_2', 'zip', 'lat', 'lng'];

    protected $table = 'addresses';

    public function city()
    {
        return $this->belongsTo('App\Model\City');
    }

    public function doctors()
    {
        return $this->belongsToMany('App\Models\Doctor');
    }

    public function hospitals()
    {
        return $this->hasMany('App\Models\Hospital');
    }
}

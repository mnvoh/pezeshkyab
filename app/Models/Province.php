<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public $fillable = ['name'];
    public $timestamps = false;

    public function cities()
    {
        return $this->hasMany('App\Models\City');
    }

    public function addresses()
    {
        return $this->hasManyThrough('App\Models\Address', 'App\Models\City');
    }
}

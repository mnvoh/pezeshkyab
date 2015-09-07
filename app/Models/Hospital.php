<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    public $timestamps = false;
    public $fillable = ['address_id', 'name'];

    public function address()
    {
        return $this->belongsTo('App\Models\Address');
    }

    public function doctors()
    {
        return $this->belongsToMany('App\Models\Doctor');
    }
}

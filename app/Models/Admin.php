<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    public $timestamps = false;
    public $fillable = ['username', 'password', 'name', 'lname', 'type', 'last_login', 'last_activity'];

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }
}

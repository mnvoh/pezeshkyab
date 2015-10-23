<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    public $timestamps = false;
    public $fillable = ['title', 'description', 'rate'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $table = 'specialties';
    public $timestamps = false;
    public $fillable = ['title', 'desc', 'image_id'];

    public function doctors()
    {
        return $this->belongsToMany('App\Models\Doctor');
    }

    public function image()
    {
        return $this->belongsTo('App\Models\Image');
    }
}

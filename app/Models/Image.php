<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $fillable = ['path', 'orig_name', 'doctor_id', 'admin_id'];

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor');
    }

    public function specialties()
    {
        return $this->hasMany('App\Models\Specialty');
    }
}

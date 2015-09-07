<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalQuestion extends Model
{
    public $fillable = ['fname', 'email', 'doctor_id', 'title', 'desc', 'scope', 'response'
        , 'created_at', 'updated_at'];

    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor');
    }
}

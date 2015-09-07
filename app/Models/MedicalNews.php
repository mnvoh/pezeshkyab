<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalNews extends Model
{
    public $fillable = ['doctor_id', 'title', 'body', 'scope', 'views'];
    protected $table = 'medical_news';

    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor');
    }
}

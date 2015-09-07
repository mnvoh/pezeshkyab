<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicChat extends Model
{
    public $timestamps = false;
    public $fillable = ['doctor_id', 'sender', 'sent_at', 'msg', 'ip'];

    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor');
    }
}

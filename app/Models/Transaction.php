<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $timestamps = false;
    public $fillable = ['doctor_id', 'amount', 'status', 'au', 'receipt', 'req_time', 'comp_time', 'patient_name'
        , 'patient_lname', 'patient_nc'];

    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor');
    }
}

<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Doctor extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    public $redirectTo = "/";

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'lname', 'ncode', 'license', 'ban', 'mobile', 'avatar'
                            , 'last_activity', 'bio', 'bd_year', 'bd_month', 'bd_date', 'status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public function addresses()
    {
        return $this->belongsToMany('App\Models\Address');
    }

    public function avatar()
    {
        return $this->belongsTo('App\Models\Image');
    }

    public function diseases()
    {
        return $this->hasMany('App\Models\Disease');
    }

    public function hospitals()
    {
        return $this->belongsToMany('App\Models\Hospital');
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

    public function medicalNews()
    {
        return $this->hasMany('App\Models\MedicalNews');
    }

    public function medicalQuestions()
    {
        return $this->hasMany('App\Models\MedicalQuestion');
    }

    public function publicChats()
    {
        return $this->hasMany('App\Models\PublicChat');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }

    public function reservations()
    {
        return $this->hasMany('App\Models\Reservation');
    }

    public function specialties()
    {
        return $this->belongsToMany('App\Models\Specialty');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }
}

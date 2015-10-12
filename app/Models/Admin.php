<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Admin extends Model implements AuthenticatableContract
{
	use Authenticatable;

	public $redirectTo = "/";

    public $timestamps = false;
    public $fillable = ['email', 'password', 'name', 'lname', 'type', 'last_login', 'last_activity'];
	protected $hidden = ['password', 'remember_token'];

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }
}

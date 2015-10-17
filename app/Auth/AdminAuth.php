<?php
/**
 * Created by PhpStorm.
 * User: mnvoh
 * Date: 10/16/15
 * Time: 1:07 PM
 */

namespace App\Auth;


use Illuminate\Support\Facades\Facade;

class AdminAuth extends Facade
{
	protected static function getFacadeAccessor()
	{
		return AdminAuthManager::class;
	}

}
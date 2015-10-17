<?php
/**
 * Created by PhpStorm.
 * User: mnvoh
 * Date: 10/16/15
 * Time: 11:45 AM
 */

namespace App\Auth;


use Illuminate\Support\ServiceProvider;

class AdminAuthServiceProvider extends ServiceProvider
{
	public function boot()
	{

	}

	public function register()
	{
		$this->app->bind(AdminAuthManager::class, function($app) {
			return new AdminAuthManager($app);
		});
	}
}
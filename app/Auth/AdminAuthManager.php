<?php
/**
 * Created by PhpStorm.
 * User: mnvoh
 * Date: 10/16/15
 * Time: 11:55 AM
 */

namespace App\Auth;


use App\Models\Admin;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;


class AdminAuthManager
{
	const SESSION_ADMIN_ID = "admin_id";
	const COOKIE_NAME = "ar";
	private $request;

	public function __construct($app)
	{
		$this->request = $app['request'];
	}

	/**
	 * Attempts to login the admin using the credentials provided.
	 * @param $email	String	The email address of the admin
	 * @param $password	String	The password - Plain Text
	 * @param $remember	boolean	Whether to remember the session or not.
	 * 
	 * @return boolean True on success and false on failure(wrong credentials).
	 */
	public function attempt($email, $password, $remember)
	{
		$admin = Admin::where('email', $email)->first();
		if(!$admin) {
			return false;
		}

		if(!Hash::check($password, $admin->password)) {
			return false;
		}

		$this->request->session()->set(AdminAuthManager::SESSION_ADMIN_ID, $admin->id);

		$remember_token = null;

		if($remember) {
			$remember_token = bcrypt($email . $password . time() . str_random(32));
			Cookie::queue(Cookie::forever(AdminAuthManager::COOKIE_NAME, $remember_token));
		}

		Admin::where('email', $email)->update([
			'last_login' => date('Y-m-d H:i:s'),
			'remember_token' => $remember_token,
		]);

		return true;
	}

	/**
	 * Checks to see if an admin is currently logged in.
	 *
	 * @return boolean True if an admin is currently logged in, false otherwise.
	 */
	public function check()
	{
		if($this->request->session()->get(AdminAuthManager::SESSION_ADMIN_ID, null)) {
			return true;
		}
		$auth_cookie = $this->request->cookie(AdminAuthManager::COOKIE_NAME);
		if($auth_cookie !== false && $auth_cookie != null) {
			$admin = Admin::where('remember_token', $auth_cookie)->first();
			if($admin) {
				$this->request->session()->set(AdminAuthManager::SESSION_ADMIN_ID, $admin->id);
				return true;
			}
		}

		return false;
	}

	/**
	 * If an admin is logged in, this method returns an instance of \App\Models\Admin
	 * corresponding to this admin.
	 *
	 * @return \App\Models\Admin An instance of the Admin class, null if no admin is logged in
	 */
	public function admin()
	{
		if(!$this->check()) {
			return null;
		}

		return Admin::where('id', $this->request->session()->get(AdminAuthManager::SESSION_ADMIN_ID))->first();
	}

	public function logout()
	{
		$this->request->session()->forget(AdminAuthManager::SESSION_ADMIN_ID);
		Cookie::queue(Cookie::forget(AdminAuthManager::COOKIE_NAME));
	}
}
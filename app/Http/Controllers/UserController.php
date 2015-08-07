<?php
namespace App\Http\Controllers;

class UserController extends Controller {

    public function login() {
        return view('user.login');
    }

    public function register() {
        return view('user.register', [
			'includeMaps' => true,
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminsController extends Controller
{
    public function home(Request $request)
	{
		return view('admin.home');
	}
}

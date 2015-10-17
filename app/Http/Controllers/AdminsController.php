<?php

namespace App\Http\Controllers;

use App\Auth\AdminAuth;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Fee;
use App\Models\Hospital;
use App\Models\MedicalNews;
use App\Models\MedicalQuestion;
use App\Models\PublicChat;
use App\Models\Reservation;
use App\Models\Specialty;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminsController extends Controller
{
	public function __construct()
	{
		view()->share('user_admin_navbar', true);
	}


	public function loginGet(Request $request)
	{
		return view('admin.login');
	}

	public function loginPost(Request $request)
	{
		$email = $request->get('email', null);
		$password = $request->get('password', null);
		$remember = $request->has('remember_me');

		$error = array();

		if($email == null || !strlen($email)) {
			$error[] = trans('main4.email_cannot_be_empty');
		}

		if($password == null || !strlen($password)) {
			$error[] = trans('main4.email_cannot_be_empty');
		}

		if(count($error)) {
			return view('admin.login', [
				'error' => $error,
			]);
		}

		if(!AdminAuth::attempt($email, $password, $remember)) {
			$error[] = trans('auth.failed');
		}

		if(count($error)) {
			return view('admin.login', [
				'error' => $error,
			]);
		}

		return redirect()->route('admins.home');
	}

	public function logout()
	{
		AdminAuth::logout();
		return redirect()->route('main.docfinder_home');
	}

    public function home(Request $request)
	{
		if(!AdminAuth::check()) {
			abort(403, 'access denied');
			return;
		}
		$admin = AdminAuth::admin();

		$data = array();
		$data['active_doctors'] = Doctor::where('status', 'active')->get()->count();
		$data['pending_doctors'] = Doctor::where('status', 'pending')->get()->count();
		$data['banned_doctors'] = Doctor::where('status', 'banned')->get()->count();
		$data['total_doctors'] = $data['active_doctors'] + $data['pending_doctors']
			+ $data['banned_doctors'];

		if($admin->type == 'master') {
			$data['master_admin'] = true;
			$data['minor_admins'] = Admin::where('type', 'minor')->count();
			$data['master_admins'] = Admin::where('type', 'master')->count();
			$data['total_admins'] = $data['minor_admins'] + $data['master_admins'];
		}

		$data['finished_transactions'] = Transaction::whereNotNull('comp_time')->count();
		$data['unsettled_transactions'] = Transaction::whereNotNull('comp_time')
			->where('settled', 0)->count();


		$data['active_reservations'] = Reservation::whereNotNull('tracking_code')
			->where('rtime', '>', date('Y-m-d H:i:s'))->count();
		$data['free_reservations'] = Reservation::whereNull('tracking_code')
			->where('rtime', '>', date('Y-m-d H:i:s'))->count();
		$data['done_reservations'] = Reservation::whereNotNull('tracking_code')
			->where('rtime', '<', date('Y-m-d H:i:s'))->count();


		$data['medical_questions'] = MedicalQuestion::count();
		$data['answered_questions'] = MedicalQuestion::whereNotNull('response')->count();
		$data['unanswered_questions'] = $data['medical_questions'] - $data['answered_questions'];


		$data['fees'] = Fee::count() * 34234;
		$data['hospitals'] = Hospital::count() * 53434425;
		$data['medical_news'] = MedicalNews::count() * 469587564;
		$data['chat_msgs'] = PublicChat::count();
		$data['specialties'] = Specialty::count();

		return view('admin.home', $data);
	}

	public function doctors(Request $request)
	{
		if(!AdminAuth::check()) {
			abort(403, 'access denied');
			return;
		}

		$doctors = Doctor::paginate(10);

		return view('admin.doctors',[
			'doctors' => $doctors,
		]);
	}
}

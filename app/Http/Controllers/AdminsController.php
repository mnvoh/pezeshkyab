<?php

namespace App\Http\Controllers;

use App\Auth\AdminAuth;
use App\Helpers\Utils;
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
use Illuminate\Support\Facades\Config;

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
			$error[] = trans('main.email_cannot_be_empty');
		}

		if($password == null || !strlen($password)) {
			$error[] = trans('main.email_cannot_be_empty');
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


		$data['fees'] = Fee::count();
		$data['hospitals'] = Hospital::count();
		$data['medical_news'] = MedicalNews::count();
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

		$action_error = false;
		$action_message = null;
		$delete_doctor = null;

		if($request->has('activate')) {
			$doctor = Doctor::where('id', $request->get('doctor_id', null))->first();
			if(!$doctor) {
				$action_error = true;
				$action_message = trans('main.doctor_doesnot_exist');
			}
			else {
				if($doctor->status == 'pending') {
					//this is the first time we're activatint the user, so send an email
					$to = $doctor->email;
					$from = trans('main.app_title');
					$from_addr = 'no-reply@' . Config::get('app.domain');
					$title = trans('main.account_activated');
					$content = trans('main.account_activated_email', [
						'docname' => $doctor->name . ' ' . $doctor->lname
					]);
					Utils::sendEmail($request, $to, $from, $from_addr, $title, $content, 'account-activated');
				}
				$doctor->status = 'active';
				$doctor->save();
				$action_message = trans('main.doctor_activated');
			}
		}
		else if($request->has('ban')) {
			$doctor = Doctor::where('id', $request->get('doctor_id', null))->first();
			if(!$doctor) {
				$action_error = true;
				$action_message = trans('main.doctor_doesnot_exist');
			}
			else {
				$doctor->status = 'banned';
				$doctor->save();
				$action_message = trans('main.doctor_banned');
			}
		}
		else if($request->has('delete')) {
			$delete_doctor = Doctor::where('id', $request->get('doctor_id', null))->first();
		}
		else if($request->has('confirm-deletion')) {
			Doctor::where('id', $request->get('doctor_id', null))->delete();
			$action_message = trans('main.doctor_deleted');
		}
		else if($request->has('register-payment')) {
			if(strlen($request->get('tracking_number')) < 2
				|| strlen($request->get('transaction_time')) < 2) {
				$action_error = true;
				$action_message = trans('main.incomplete_information');
			}
			else {
				Transaction::where('doctor_id', $request->get('doctor_id'))
					->where('status', 'paid')
					->where('settled', 0)
					->update([
						'settled' => 1,
						'settlement_tracking_number' => $request->get('tracking_number'),
						'settlement_transaction_time' => $request->get('transaction_time'),
					]);
			}

		}


		$ncode = $request->get('ncode', '');
		$license = $request->get('license', '');
		$email = $request->get('email', '');
		$status = $request->get('status', '');

		if(strlen($ncode) + strlen($license) + strlen($email) + strlen($status) <= 0) {
			$doctors = Doctor::paginate(10);
		}
		else {
			$doctors = Doctor::where(function($query) use ($ncode, $license, $email, $status) {
				if(strlen($ncode)) {
					$query->where('ncode', 'LIKE', "%{$ncode}%");
				}
				if(strlen($license)) {
					$query->where('license', 'LIKE', "%{$license}%");
				}
				if(strlen($email)) {
					$query->where('email', 'LIKE', "%{$email}%");
				}
				if(strlen($status) && $status != 'all') {
					$query->where('status', $status);
				}
				return $query;
			})->paginate(10);
		}

		return view('admin.doctors',[
			'doctors' => $doctors,
			'master_admin' => AdminAuth::admin()->type == 'master',
			'filter_email' => $request->get('email', ''),
			'filter_ncode' => $request->get('ncode', ''),
			'filter_license' => $request->get('license', ''),
			'filter_status' => $request->get('status', 'all'),
			'action_error' => $action_error,
			'action_message' => $action_message,
			'delete_doctor' => $delete_doctor,
		]);
	}

	public function admins(Request $request)
	{
		if(!AdminAuth::check()) {
			abort(403, 'access denied');
			return;
		}


		$action_error = false;
		$action_message = null;
		$delete_admin = null;

		if($request->has('delete')) {
			if($request->get('admin_id', null) == AdminAuth::admin()->id) {
				$action_error = true;
				$action_message = trans('main.delete_yourself');
			}
			else {
				$delete_admin = Admin::where('id', $request->get('admin_id', null))->first();
			}
		}
		else if($request->has('confirm-deletion')) {
			Admin::where('id', $request->get('admin_id', null))->delete();
			$action_message = trans('main.admin_deleted');
		}
		else if($request->has('change-password')) {
			$pass1 = $request->get('new_password');
			$pass2 = $request->get('new_password_r');
			if(strlen($pass1) < 6) {
				$action_error = true;
				$action_message = trans('main.password_short');
			}
			else if($pass1 != $pass2) {
				$action_error = true;
				$action_message = trans('main.password_mismatch');
			}
			else {
				Admin::where('id', $request->get('admin_id'))
					->update([
						'password' => bcrypt($pass1),
					]);
				$action_message = trans('main.password_changed');
			}
		}
		else if($request->has('add-admin')) {
			$admin = new Admin();
			$admin->email = $request->get('email');
			$admin->password = bcrypt($request->get('password'));
			$admin->name = $request->get('name');
			$admin->lname = $request->get('lname');
			$admin->type = 'minor';
			$admin->save();

			$action_error = false;
			$action_message = trans('main.admin_created');
		}

		$id = $request->get('id', '');
		$type = $request->get('type', '');
		$email = $request->get('email', '');

		if(strlen($id) + strlen($type) + strlen($email) <= 0) {
			$admins = Admin::paginate(10);
		}
		else {
			$admins = Admin::where(function($query) use ($id, $type, $email) {
				if(strlen($id)) {
					$query->where('id', $id);
				}
				if(strlen($type) && $type != 'any') {
					$query->where('type', $type);
				}
				if(strlen($email)) {
					$query->where('email', 'LIKE', "%{$email}%");
				}
				return $query;
			})->paginate(10);
		}

		return view('admin.admins', [
			'admins' => $admins,
			'filter_email' => $request->get('email', ''),
			'filter_id' => $request->get('id', ''),
			'filter_type' => $request->get('type', ''),
			'action_error' => $action_error,
			'action_message' => $action_message,
			'delete_admin' => $delete_admin,
		]);
	}

	public function transactions(Request $request)
	{
		if(!AdminAuth::check()) {
			abort(403, 'access denied');
			return;
		}

		$doctor_id = $request->get('doctor_id', '');
		$status = $request->get('status', '');
		$settled = $request->get('settled', '');
		$receipt = $request->get('receipt', '');
		$gross = null;

		if($status == 'any') $status = '';
		if($settled == 'any') $settled = '';

		if(strlen($doctor_id) + strlen($receipt) + strlen($status) + strlen($settled) <= 0) {
			$transactions = Transaction::paginate(10);
		}
		else {
			$transactions = Transaction::where(function($query) use ($doctor_id, $receipt, $settled, $status) {
				if(strlen($doctor_id)) {
					$query->where('doctor_id', $doctor_id);
				}
				if(strlen($receipt)) {
					$query->where('au', 'LIKE', "%{$receipt}%");
				}
				if(strlen($settled)) {
					$query->where('settled', $settled);
				}
				if(strlen($status) && $status != 'all') {
					$query->where('status', $status);
				}
				return $query;
			})->paginate(10);

			$gross = Transaction::where(function($query) use ($doctor_id, $receipt, $settled, $status) {
				if(strlen($doctor_id)) {
					$query->where('doctor_id', $doctor_id);
				}
				if(strlen($receipt)) {
					$query->where('au', 'LIKE', "%{$receipt}%");
				}
				if(strlen($settled)) {
					$query->where('settled', $settled);
				}
				if(strlen($status) && $status != 'all') {
					$query->where('status', $status);
				}
				return $query;
			})->sum('amount');
		}

		return view('admin.transactions', [
			'transactions' => $transactions,
			'gross' => $gross,
			'master_admin' => AdminAuth::admin()->type == 'master',
			'filter_doctor_id' => $request->get('doctor_id', ''),
			'filter_receipt' => $request->get('receipt', ''),
			'filter_settled' => $settled,
			'filter_status' => $status,
		]);
	}

	public function reservations(Request $request)
	{
		if(!AdminAuth::check()) {
			abort(403, 'access denied');
			return;
		}

		$doctor_id = $request->get('doctor_id', '');
		$ncode = $request->get('ncode', '');
		$tracking_code = $request->get('tracking_code', '');

		if(strlen($doctor_id) + strlen($ncode) + strlen($tracking_code) <= 0) {
			$reservations = Reservation::paginate(10);
		}
		else {
			$reservations = Reservation::where(function($query) use ($doctor_id, $ncode, $tracking_code) {
				if(strlen($doctor_id)) {
					$query->where('doctor_id', $doctor_id);
				}
				if(strlen($ncode)) {
					$query->where('ncode', $ncode);
				}
				if(strlen($tracking_code)) {
					$query->where('tracking_code', $tracking_code);
				}
				return $query;
			})->paginate(10);
		}

		return view('admin.reservations', [
			'reservations' => $reservations,
			'master_admin' => AdminAuth::admin()->type == 'master',
			'filter_doctor_id' => $request->get('doctor_id', ''),
			'filter_ncode' => $request->get('ncode', ''),
			'filter_tracking_code' => $tracking_code,
		]);
	}

	public function medicalQuestions(Request $request)
	{
		if(!AdminAuth::check()) {
			abort(403, 'access denied');
			return;
		}

		$delete_question = null;
		$action_message = null;

		if($request->has('delete')) {
			$delete_question = MedicalQuestion::where('id', $request->get('mqid', null))->first();
		}
		else if($request->has('confirm-deletion')) {
			MedicalQuestion::where('id', $request->get('mqid', null))->delete();
			$action_message = trans('main.medical_question_deleted');
		}

		$answered = $request->get('answered', 'any');

		if($answered != 'answered' && $answered != 'unanswered') {
			$questions = MedicalQuestion::paginate(10);
		}
		else {
			$questions = MedicalQuestion::where(function($query) use ($answered) {
				if($answered == 'answered') {
					$query->whereNotNull('response');
				}
				else if($answered == 'unanswered') {
					$query->whereNull('response');
				}
				return $query;
			})->paginate(10);
		}

		return view('admin.medical-questions', [
			'questions' => $questions,
			'master_admin' => AdminAuth::admin()->type == 'master',
			'filter_answered' => $answered,
			'action_message' => $action_message,
			'delete_question' => $delete_question,
		]);
	}
}

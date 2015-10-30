<?php

namespace App\Http\Controllers;

use App\Auth\AdminAuth;
use App\Helpers\Utils;
use App\Models\Address;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Fee;
use App\Models\Hospital;
use App\Models\Image;
use App\Models\Insurance;
use App\Models\Link;
use App\Models\MedicalNews;
use App\Models\MedicalQuestion;
use App\Models\PublicChat;
use App\Models\Reservation;
use App\Models\Specialty;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests;
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
		$data['insurances'] = Insurance::count();
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

		if($request->has('activate') && $this->isMasterAdmin()) {
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
		else if($request->has('ban') && $this->isMasterAdmin()) {
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
//		else if($request->has('delete') && $this->isMasterAdmin()) {
//			$delete_doctor = Doctor::where('id', $request->get('doctor_id', null))->first();
//		}
//		else if($request->has('confirm-deletion') && $this->isMasterAdmin()) {
//			Doctor::where('id', $request->get('doctor_id', null))->delete();
//			$action_message = trans('main.doctor_deleted');
//		}
		else if($request->has('register-payment') && $this->isMasterAdmin()) {
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
			$doctors = Doctor::paginate(Config::get('constants.ITEMS_PER_PAGE'));
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
			})->paginate(Config::get('constants.ITEMS_PER_PAGE'));
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
		if(!AdminAuth::check() || !$this->isMasterAdmin()) {
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
			$admins = Admin::paginate(Config::get('constants.ITEMS_PER_PAGE'));
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
			})->paginate(Config::get('constants.ITEMS_PER_PAGE'));
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
		if($settled == '0' || $settled == '1') $status = 'paid';

		if(strlen($doctor_id) + strlen($receipt) + strlen($status) + strlen($settled) <= 0) {
			$transactions = Transaction::paginate(Config::get('constants.ITEMS_PER_PAGE'));
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
			})->paginate(Config::get('constants.ITEMS_PER_PAGE'));

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
		if(!AdminAuth::check() || !$this->isMasterAdmin()) {
			abort(403, 'access denied');
			return;
		}

		$doctor_id = $request->get('doctor_id', '');
		$ncode = $request->get('ncode', '');
		$tracking_code = $request->get('tracking_code', '');
		$status = $request->get('status', '');

		if(strlen($doctor_id) + strlen($ncode) + strlen($tracking_code) + strlen($status) <= 0) {
			$reservations = Reservation::paginate(Config::get('constants.ITEMS_PER_PAGE'));
		}
		else {
			$reservations = Reservation::where(function($query) use ($doctor_id, $ncode, $tracking_code, $status) {
				if(strlen($doctor_id)) {
					$query->where('doctor_id', $doctor_id);
				}
				if(strlen($ncode)) {
					$query->where('ncode', $ncode);
				}
				if(strlen($tracking_code)) {
					$query->where('tracking_code', $tracking_code);
				}
				if(strlen($status)) {
					if($status == 'active')
						$query->whereNotNull('tracking_code')->where('rtime', '>', date('Y-m-d H:i:s'));
					else if($status == 'free')
						$query->whereNull('tracking_code')->where('rtime', '>', date('Y-m-d H:i:s'));
					else if($status == 'done')
						$query->whereNotNull('tracking_code')->where('rtime', '<', date('Y-m-d H:i:s'));
				}
				return $query;
			})->paginate(Config::get('constants.ITEMS_PER_PAGE'));
		}

		return view('admin.reservations', [
			'reservations' => $reservations,
			'master_admin' => AdminAuth::admin()->type == 'master',
			'filter_doctor_id' => $request->get('doctor_id', ''),
			'filter_ncode' => $request->get('ncode', ''),
			'filter_tracking_code' => $tracking_code,
			'filter_status' => $status,
		]);
	}

	public function medicalQuestions(Request $request)
	{
		if(!AdminAuth::check() || !$this->isMasterAdmin()) {
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
			$questions = MedicalQuestion::paginate(Config::get('constants.ITEMS_PER_PAGE'));
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
			})->paginate(Config::get('constants.ITEMS_PER_PAGE'));
		}

		return view('admin.medical-questions', [
			'questions' => $questions,
			'master_admin' => AdminAuth::admin()->type == 'master',
			'filter_answered' => $answered,
			'action_message' => $action_message,
			'delete_question' => $delete_question,
		]);
	}

	public function fees(Request $request)
	{
		if(!AdminAuth::check()) {
			abort(403, 'access denied');
			return;
		}

		$action_message = null;

		if($request->has('delete')) {
			Fee::where('id', $request->get('fee_id', null))->delete();
			$action_message = trans('main.fee_deleted');
		}
		elseif($request->has('save')) {
			if($request->has('fee_id') && (int)$request->get('fee_id', 0) > 0) {
				Fee::where('id', $request->get('fee_id', null))
					->update([
						'title' => $request->get('title', ''),
						'amount' => $request->get('amount', 0),
					]);
			}
			else {
				$new_fee = new Fee;
				$new_fee->title = $request->get('title', '');
				$new_fee->amount = $request->get('amount', 0);
				$new_fee->save();
			}
			$action_message = trans('main.fee_saved');
		}

		$title = $request->get('title', '');

		if(strlen($title) <= 0) {
			$fees = Fee::paginate(Config::get('constants.ITEMS_PER_PAGE'));
		}
		else {
			$fees = Fee::where(function($query) use ($title) {
				if(strlen($title) > 0) {
					$query->where('title', 'LIKE', "%{$title}%");
				}
				return $query;
			})->paginate(Config::get('constants.ITEMS_PER_PAGE'));
		}

		return view('admin.fees', [
			'fees' => $fees,
			'master_admin' => AdminAuth::admin()->type == 'master',
			'filter_title' => $title,
			'action_message' => $action_message,
		]);
	}

	public function insurances(Request $request)
	{
		if(!AdminAuth::check()) {
			abort(403, 'access denied');
			return;
		}

		$action_message = null;

		if($request->has('delete')) {
			Insurance::where('id', $request->get('insurance_id', null))->delete();
			$action_message = trans('main.insurance_deleted');
		}
		elseif($request->has('save')) {
			if($request->has('insurance_id') && (int)$request->get('insurance_id', 0) > 0) {
				Insurance::where('id', $request->get('insurance_id', null))
					->update([
						'title' => $request->get('title', ''),
						'description' => $request->get('description', ''),
						'rate' => $request->get('rate', 0) / 100,
					]);
			}
			else {
				$new_insurance = new Insurance;
				$new_insurance->title = $request->get('title', '');
				$new_insurance->description = $request->get('description', '');
				$new_insurance->rate = $request->get('rate', 0) / 100;
				$new_insurance->save();
			}
			$action_message = trans('main.insurance_saved');
		}

		$title = $request->get('title', '');

		if(strlen($title) <= 0) {
			$insurances = Insurance::paginate(Config::get('constants.ITEMS_PER_PAGE'));
		}
		else {
			$insurances = Insurance::where(function($query) use ($title) {
				if(strlen($title) > 0) {
					$query->where('title', 'LIKE', "%{$title}%");
				}
				return $query;
			})->paginate(Config::get('constants.ITEMS_PER_PAGE'));
		}

		return view('admin.insurances', [
			'insurances' => $insurances,
			'master_admin' => AdminAuth::admin()->type == 'master',
			'filter_title' => $title,
			'action_message' => $action_message,
		]);
	}

	public function specialties(Request $request)
	{
		if(!AdminAuth::check()) {
			abort(403, 'access denied');
			return;
		}

		$action_message = null;

		if($request->has('delete')) {
			Specialty::where('id', $request->get('specialty_id', null))->delete();
			$action_message = trans('main.specialty_deleted');
		}
		elseif($request->has('save')) {
			if($request->has('specialty_id') && (int)$request->get('specialty_id', 0) > 0) {
				Specialty::where('id', $request->get('specialty_id', null))
					->update([
						'title' => $request->get('title', ''),
						'desc' => $request->get('description', ''),
					]);
			}
			else {
				$new_specialty = new Specialty;
				$new_specialty->title = $request->get('title', '');
				$new_specialty->desc = $request->get('description', '');
				$new_specialty->save();
			}
			$action_message = trans('main.specialty_saved');
		}
		else if($request->has('setimage')) {
			$image_id = $request->get('setimage', 0);
			$specialty_id = $request->get('specialty_id', 0);
			Specialty::where('id', $specialty_id)
				->update([
					'image_id' => $image_id,
				]);
			return redirect()->route('admins.specialties');
		}

		$title = $request->get('title', '');

		if(strlen($title) <= 0) {
			$specialties = Specialty::paginate(Config::get('constants.ITEMS_PER_PAGE'));
		}
		else {
			$specialties = Specialty::where(function($query) use ($title) {
				if(strlen($title) > 0) {
					$query->where('title', 'LIKE', "%{$title}%");
				}
				return $query;
			})->paginate(Config::get('constants.ITEMS_PER_PAGE'));
		}

		return view('admin.specialties', [
			'specialties' => $specialties,
			'master_admin' => AdminAuth::admin()->type == 'master',
			'filter_title' => $title,
			'action_message' => $action_message,
		]);
	}

	public function uploadSpecialtyImage(Request $request)
	{
		if (isset($_FILES['file'])) {
			if(!AdminAuth::check()) {
				return response()->json([
					'error' => true,
					'error_desc' => trans('main.error_uploading') . ': 403',
				]);
			}

			$filename = basename($_FILES['file']['name']);
			$ext = (new \SplFileInfo($filename))->getExtension();
			$new_filename = sha1($filename . time() . AdminAuth::admin()->id) . ".$ext";
			$path = Config::get('constants.UPLOAD_PATH') . date('Ym') . '/' . $new_filename;
			$error = !move_uploaded_file($_FILES['file']['tmp_name'], $path);

			if($error) {
				return response()->json([
					'error' => true,
					'error_desc' => trans('main.error_uploading') . ': 100',
				]);
			}

			$image = new Image();
			$image->path = $path;
			$image->orig_name = $filename;
			$image->admin_id = AdminAuth::admin()->id;
			$image->save();

			$specialty_id = $request->get('specialty_id', 0);
			Specialty::where('id', $specialty_id)->update([
				'image_id' => $image->id,
			]);

			return response()->json(array(
				'error' => $error,
			));
		}
	}

	public function hospitals(Request $request)
	{
		if(!AdminAuth::check()) {
			abort(403, 'access denied');
			return;
		}

		$action_message = null;

		if($request->has('delete')) {
			Hospital::where('id', $request->get('hospital_id', null))->delete();
			$action_message = trans('main.hospital_deleted');
		}
		elseif($request->has('save')) {
			if($request->has('hospital_id') && (int)$request->get('hospital_id', 0) > 0) {
				Hospital::where('id', $request->get('hospital_id', null))
					->update([
						'name' => $request->get('name', ''),
					]);
			}
			else {
				$new_hospital = new Hospital;
				$new_hospital->name = $request->get('name', '');
				$new_hospital->save();
			}
			$action_message = trans('main.hospital_saved');
		}
		elseif($request->has('save-address')) {
			$new_address = new Address();
			$new_address->city_id = $request->get('city', '');
			$new_address->street_addr_1 = $request->get('addr1', '');
			$new_address->street_addr_2 = $request->get('addr2', '');
			$new_address->zip = $request->get('postal_code', '');
			$new_address->lat = $request->get('locationLat', '');
			$new_address->lng = $request->get('locationLon', '');
			$new_address->save();
			Hospital::where('id', $request->get('hospital_id', null))
				->update([
					'address_id' => $new_address->id,
				]);
			$action_message = trans('main.hospital_saved');
		}
		else if($request->has('setaddress')) {

			return redirect()->route('admins.hospitals');
		}

		$name = $request->get('name', '');

		if(strlen($name) <= 0) {
			$hospitals = Hospital::paginate(Config::get('constants.ITEMS_PER_PAGE'));
		}
		else {
			$hospitals = Hospital::where(function($query) use ($name) {
				if(strlen($name) > 0) {
					$query->where('name', 'LIKE', "%{$name}%");
				}
				return $query;
			})->paginate(Config::get('constants.ITEMS_PER_PAGE'));
		}

		return view('admin.hospitals', [
			'hospitals' => $hospitals,
			'master_admin' => AdminAuth::admin()->type == 'master',
			'filter_name' => $name,
			'action_message' => $action_message,
			'include_maps' => true,
		]);
	}

	public function medicalNews(Request $request)
	{
		if(!AdminAuth::check()) {
			abort(403, 'access denied');
			return;
		}

		$action_message = null;

		if($request->has('delete')) {
			MedicalNews::where('id', $request->get('mnid', null))->delete();
			$action_message = trans('main.medical_news_deleted');
		}

		$mednews = MedicalNews::paginate(Config::get('constants.ITEMS_PER_PAGE'));

		return view('admin.medical_news', [
			'mednews' => $mednews,
			'master_admin' => AdminAuth::admin()->type == 'master',
			'action_message' => $action_message,
		]);
	}

	public function links(Request $request)
	{
		if(!AdminAuth::check()) {
			abort(403, 'access denied');
			return;
		}

		if($request->has('delete')) {
			Link::where('id', $request->get('link_id', null))->delete();
		}
		elseif($request->has('save')) {
			$new_link = new Link;
			$new_link->title = $request->get('title', '');
			$new_link->url = $request->get('url', '');
			$new_link->save();
		}

		$links = Link::all();


		return view('admin.links', [
			'links' => $links,
			'master_admin' => AdminAuth::admin()->type == 'master',
		]);
	}

	public function chats(Request $request)
	{
		if(!AdminAuth::check()) {
			abort(403, 'access denied');
			return;
		}

		$action_message = null;

		if($request->has('delete')) {
			PublicChat::where('id', $request->get('msg_id', null))->delete();
			$action_message = 'پیغام حذف شد';
		}

		$filter = $request->get('filter', '');
		if(strlen($filter)) {
			$msgs = PublicChat::where('msg', 'LIKE', '%' . $filter . '%')
				->paginate(Config::get('constants.ITEMS_PER_PAGE'));
		}
		else {
			$msgs = PublicChat::paginate(Config::get('constants.ITEMS_PER_PAGE'));
		}


		return view('admin.chats', [
			'msgs' => $msgs,
			'master_admin' => AdminAuth::admin()->type == 'master',
			'action_message' => $action_message,
		]);
	}

	private function isMasterAdmin()
	{
		if(!AdminAuth::check())
			return false;
		if(AdminAuth::admin()->type != 'master')
			return false;
		return true;
	}
}

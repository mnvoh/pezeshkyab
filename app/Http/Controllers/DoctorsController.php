<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Fee;
use App\Models\MedicalNews;
use App\Models\MedicalQuestion;
use App\Models\Reservation;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\Utils;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DoctorsController extends Controller
{
	public function __construct()
	{
		view()->share('viewerIsOwner', false);
		view()->share('use_doctors_navbar', true);
	}

	public function homePage(Request $request, $doctor_id)
    {
		$status_message = null;
        $doctor = Doctor::where('id', $doctor_id)->firstOrFail();
		$viewer_is_owner = (Auth::check() && Auth::user()->id == $doctor_id &&
							is_a(Auth::user(), Doctor::class));
		if($request->has("editBioSubmitted") && $viewer_is_owner) {
			$new_bio = $request->get('bio');
			if(strlen($new_bio) < 100) {
				$status_message = trans('main4.bio_too_short');
			}
			else {
				$doctor->bio = $new_bio;
				$doctor->save();
				$status_message = trans('main4.bio_saved');
			}
		}

		$med_news = MedicalNews::where('doctor_id', $doctor_id)
			->orderBy('created_at', 'desc')
			->take(3)
			->get();
		$med_news_rendered = array();
		$first_news = true;
		foreach($med_news as $mn) {
			if($first_news)
				$med_news_rendered[] = $this->renderMedicalNews($mn, false);
			else
				$med_news_rendered[] = $this->renderMedicalNews($mn);
			$first_news = false;
		}

		return view('doctors.homepage', [
			'doctor_id' => $doctor_id,
			'viewerIsOwner' => $viewer_is_owner,
			'name' => $doctor->name . ' ' . $doctor->lname,
			'specialty' => $doctor->specialties[0]->title,
			'specialty_title' => $doctor->specialties[0]->desc,
			'about' => $doctor->bio,
			'feed' => $med_news_rendered,
			'status_message' => $status_message,
			'url' => route('doctors.homepage', ['doctor_id' => $doctor_id]),
		]);
	}

	public function doctorsMedNews(Request $request, $doctor_id)
	{
		$doctor = Doctor::where('id', $doctor_id)->firstOrFail();

		$med_news = MedicalNews::where('doctor_id', $doctor_id)
			->where('scope', '<>', 'sys')
			->orderBy('created_at', 'desc')
			->paginate(10);
		$med_news_rendered = array();
		$first_news = true;
		foreach($med_news as $mn) {
			if($first_news)
				$med_news_rendered[] = $this->renderMedicalNews($mn, false);
			else
				$med_news_rendered[] = $this->renderMedicalNews($mn);
			$first_news = false;
		}

		$mednews_added = false;
		if(session('status') == 'mednews_added') {
			$mednews_added = true;
		}

		return view('doctors.doctors-med-news', [
			'doctor_id' => $doctor_id,
			'viewerIsOwner' => (Auth::check() && Auth::user()->id == $doctor_id && is_a(Auth::user(), Doctor::class)),
			'name' => $doctor->name . ' ' . $doctor->lname,
			'specialty' => $doctor->specialties[0]->title,
			'specialty_title' => $doctor->specialties[0]->desc,
			'about' => $doctor->bio,
			'med_news' => $med_news,
			'feed' => $med_news_rendered,
			'mednews_added' => $mednews_added,
		]);
	}

	public function medNews(Request $request, $medical_news_id)
	{
		$med_news = MedicalNews::where('id', $medical_news_id)->firstOrFail();

		return view('doctors.med-news', [
			'doctor_id' => $med_news->doctor->id,
			'doctor_name' => $med_news->doctor->name . ' ' . $med_news->doctor->lname,
			'published_on' => Utils::shamsiDateFromGreg(strtotime($med_news->created_at)),
			'title' => $med_news->title,
			'body' => $med_news->body,
			'use_doctors_navbar' => false,

		]);
	}

	public function addMedNews(Request $request)
	{
		if(!Auth::check() || !is_a(Auth::user(), Doctor::class)) {
			app()->abort(403, "Access denied");
			return;
		}

		if($request->has('form-submitted')) {
			if(strlen($request->get('title')) < 10 && strlen($request->get('body')) < 100) {
				return view('doctors.add-med-news', [
					'url' => route('doctors.add_med_news'),
					'doctor_id' => Auth::user()->id,
					'name' => Auth::user()->name . ' ' . Auth::user()->lname,
					'specialty' => Auth::user()->specialties[0]->title,
					'specialty_title' => Auth::user()->specialties[0]->desc,
					'title_error' => TRUE,
					'body_error' => TRUE,
					'title' => $request->get('title'),
					'body' => $request->get('body'),
				]);
			}
			else if(strlen($request->get('title')) < 10) {
				return view('doctors.add-med-news', [
					'url' => route('doctors.add_med_news'),
					'doctor_id' => Auth::user()->id,
					'viewerIsOwner' => true,
					'name' => Auth::user()->name . ' ' . Auth::user()->lname,
					'specialty' => Auth::user()->specialties[0]->title,
					'specialty_title' => Auth::user()->specialties[0]->desc,
					'title_error' => TRUE,
					'title' => $request->get('title'),
					'body' => $request->get('body'),
				]);
			}
			else if(strlen($request->get('body')) < 100) {
				return view('doctors.add-med-news', [
					'url' => route('doctors.add_med_news'),
					'doctor_id' => Auth::user()->id,
					'viewerIsOwner' => true,
					'name' => Auth::user()->name . ' ' . Auth::user()->lname,
					'specialty' => Auth::user()->specialties[0]->title,
					'specialty_title' => Auth::user()->specialties[0]->desc,
					'body_error' => TRUE,
					'title' => $request->get('title'),
					'body' => $request->get('body'),
				]);
			}

			$mednews = new MedicalNews();
			$mednews->doctor_id = Auth::user()->id;
			$mednews->title = $request->get('title');
			$mednews->body = $request->get('body');
			$mednews->scope = $request->get('scope');
			$mednews->save();

			return redirect()
				->route("doctors.articles", ['doctor_id' => Auth::user()->id])
				->with('status', 'mednews_added');
		}

		return view('doctors.add-med-news', [
			'url' => route('doctors.add_med_news'),
			'doctor_id' => Auth::user()->id,
			'viewerIsOwner' => true,
			'name' => Auth::user()->name . ' ' . Auth::user()->lname,
			'specialty' => Auth::user()->specialties[0]->title,
			'specialty_title' => Auth::user()->specialties[0]->desc,
			'title' => '',
			'body' => '',
		]);
	}

	public function ask(Request $request, $doctor_id = null)
	{
		$request->flash();
		$status_message = array();
		$form_error = false;
		$done = false;

		if($doctor_id == null && $request->has('doctor_id')) {
			$doctor_id = $request->get('doctor_id');
		}

		$doctor = null;
		if($doctor_id) {
			$doctor = Doctor::where('id', $doctor_id)->first();
		}
		if($request->has('question_submitted')) {
			if(!$doctor_id) {
				$status_message[] = trans('main4.invalid_doctor');
				$form_error = true;
			}
			else {
				if(!$doctor) {
					$status_message[] = trans('main4.invalid_doctor');
					$form_error = true;
				}
			}


			if(strlen($request->get('q_name')) < 4) {
				$status_message[] = trans('main4.invalid_name');
				$form_error = true;
			}

			if(!filter_var($request->get('q_email'), FILTER_VALIDATE_EMAIL)) {
				$status_message[] = trans('main4.invalid_email');
				$form_error = true;
			}

			if(strlen($request->get('q_title')) < 10) {
				$status_message[] = trans('main4.invalid_title');
				$form_error = true;
			}

			if(strlen($request->get('q_question')) < 50) {
				$status_message[] = trans('main4.invalid_question');
				$form_error = true;
			}

			if(!$form_error) {
				$med_question = new MedicalQuestion();
				$med_question->fname = $request->get('q_name');
				$med_question->email = $request->get('q_email');
				$med_question->doctor_id = $doctor_id;
				$med_question->title = $request->get('q_title');
				$med_question->question = $request->get('q_question');
				$med_question->scope = $request->get('q_scope');
				$med_question->save();
				$done = true;
			}
		}

		$old_doctor_description = null;
		if($doctor != null) {
			$old_doctor_description = $doctor->name . ' ' . $doctor->lname . ' &middot; ';
			foreach($doctor->specialties as $s) {
				$old_doctor_description .= " " . $s->title . " ";
			}
			$old_doctor_description .= " &middot; ";
			foreach($doctor->addresses as $a) {
				$old_doctor_description .= " " . $a->city->name . " ";
			}
		}

		return view('doctors.ask-medical-question', [
			'use_doctors_navbar' 	 => false,
			'standalone' 			 => true,
			'old_doctor_id' 		 => $doctor_id,
			'old_doctor_description' => $old_doctor_description,
			'status_message' 		 => $status_message,
			'form_error' 			 => $form_error,
			'done' 					 => $done,
		]);
	}

	public function askedQuestions(Request $request)
	{
		if(!Auth::check() || !is_a(Auth::user(), Doctor::class)) {
			abort(403, 'access denied');
			return;
		}

		$doctor = Auth::user();

		if($request->has('reply_sent')) {
			$med_question = MedicalQuestion::where('id', $request->get('qid'))->first();
			if($med_question) {
				$med_question->response = $request->get('response');
				$med_question->save();

				$to = $med_question->email;
				$from_name = $med_question->doctor->name . ' ' . $med_question->doctor->lname .
					' | ' . trans('email.signature_line2');
				$from_address = null;
				$subject = trans('email.med_question_response');
				$content = [
					'question' => $med_question->question,
					'response' => $med_question->response,
				];

				Utils::sendEmail($request, $to, $from_name, $from_address, $subject, $content
					, 'medical-question-response');
			}
		}

		$med_questions = MedicalQuestion::where('doctor_id', $doctor->id)
			->orderby('created_at', 'desc')
			->paginate(10);

		return view('doctors.medical-questions', [
			'doctor_id' => $doctor->id,
			'viewerIsOwner' => true,
			'name' => $doctor->name . ' ' . $doctor->lname,
			'specialty' => $doctor->specialties[0]->title,
			'specialty_title' => $doctor->specialties[0]->desc,
			'medical_questions' => $med_questions,
		]);
	}

	public function schedule(Request $request)
	{
		if(!Auth::check() || !is_a(Auth::user(), Doctor::class)) {
			abort(403, 'access denied');
			return;
		}

		$doctor = Auth::user();

		$status_message = null;
		$form_error = false;

		if($request->has('new_reservation')) {
			$year = $request->get('year');
			$month = $request->get('month');
			$date = $request->get('date');
			$hour = $request->get('hour');
			$minute = $request->get('minute');
			$fee_id = $request->get('fee');
			$cyear = jdate('Y', time(), '', 'Asia/Tehran', 'en');
			if($hour 	> 23 		|| $hour < 0
			|| $minute 	< 0 		|| $minute > 60
			|| $year 	< $cyear	|| $year > $cyear + 1
			|| $month 	> 12 		|| $month < 1
			|| $date 	> 31 		|| $date < 1) {
				$status_message = trans('main4.invalid_time');
				$form_error = true;
			}
			else {
				$greg_date = jalali_to_gregorian($year, $month, $date);
				$new_reservation = new Reservation();
				$new_reservation->doctor_id = $doctor->id;
				$new_reservation->rtime = date('Y-m-d H:i:s',
					mktime($hour, $minute, 0, $greg_date[1], $greg_date[2], $greg_date[0]));
				$new_reservation->fee_id = $fee_id;
				$new_reservation->save();
				$status_message = trans('main4.reservation_saved');
			}
		}
		else if($request->has('delete_reservation')) {
			$reservation = Reservation::where('id', $request->get('reservation_id'))->first();
			if($reservation && $reservation->tracking_code == null) {
				$reservation->delete();
				$status_message = trans('main4.schedule_deleted');
			}
			else {
				$form_error = true;
				$status_message = trans('main4.schedule_not_deleted');
			}
		}

		$current_reservations = Reservation::where('doctor_id', $doctor->id)
			->where('rtime', '>', date('Y-m-d H:i:s'))
			->get();

		return view('doctors.schedule', [
			'doctor_id' => $doctor->id,
			'viewerIsOwner' => true,
			'name' => $doctor->name . ' ' . $doctor->lname,
			'specialty' => $doctor->specialties[0]->title,
			'specialty_title' => $doctor->specialties[0]->desc,
			'status_message' => $status_message,
			'form_error' => $form_error,
			'reservations' => $current_reservations,
			'fees' => Fee::all(),
			'url' => route('doctors.schedule'),
			'current_year' => jdate('Y', time(), '', 'Asia/Tehran', 'en'),
			'current_month' => jdate('m', time(), '', 'Asia/Tehran', 'en'),
			'current_date' => jdate('d', time(), '', 'Asia/Tehran', 'en'),
		]);
	}

	public function transactions(Request $request)
	{
		if(!Auth::check() || !is_a(Auth::user(), Doctor::class)) {
			abort(403, 'access denied');
			return;
		}

		$doctor = Auth::user();

		$transactions = Transaction::where('doctor_id', $doctor->id)
			->orderBy('id', 'desc')
			->paginate(10);

		$paid_gross = Transaction::where('doctor_id', $doctor->id)
			->where('status', 'paid')
			->sum('amount');

		return view('doctors.transactions', [
			'doctor_id' => $doctor->id,
			'viewerIsOwner' => true,
			'name' => $doctor->name . ' ' . $doctor->lname,
			'specialty' => $doctor->specialties[0]->title,
			'specialty_title' => $doctor->specialties[0]->desc,
			'transactions' => $transactions,
			'paid_gross' => $paid_gross,
		]);
	}

	public function emailPatientForReservation (Request $request)
	{
		if(!Auth::check() || !is_a(Auth::user(), Doctor::class)) {
			abort(403, 'access denied');
			return;
		}

		if(!$request->has('reservation_id')) {
			return response()->json([
				'error' => true,
				'description' => trans('main4.invalid_reservation_id'),
			]);
		}

		$id = $request->get('reservation_id');
		$reservation = Reservation::where('id', $id)->first();
		if(!$reservation) {
			return response()->json([
				'error' => true,
				'description' => trans('main4.invalid_reservation_id'),
			]);
		}


		$title = $request->get('subject') . trans('email.signature_line2');
		$content = $request->get('message');

		$to = $reservation->pemail;
		$from = $reservation->doctor->name . ' ' . $reservation->doctor->lname . '(' .
			trans('email.signature_line2') . ')';
		$from_addr = $reservation->doctor->email;

		Utils::sendEmail($request, $to, $from, $from_addr, $title, $content, 'doctor-reservation');

		return response()->json([
			'error' => false,
			'description' => trans('email.sent'),
		]);
	}

    public function renderMedicalNews(MedicalNews $mednews,
									  $halfWidth = true )
    {
		/***************************************************
		 * ************        ATTENSION     ***************
		 * Remember to reflect any changes you make here
		 * to MainController@renderMedicalNews
		 ***************************************************/

        $url = $title = $doctor_name = $doctor_id = $published_on = $cover_image = $content = "";

        $url = route('doctors.article', [
			'medical_news_id' => $mednews->id,
			'title' => urlencode($mednews->title),
		]);
        $title = $mednews->title;
        $doctor_id = $mednews->doctor->id;
        $doctor_name = $mednews->doctor->name . ' ' . $mednews->doctor->lname;
        $published_on = Utils::shamsiDateFromGreg(strtotime($mednews->created_at));
        $content = strip_tags(Utils::truncate($mednews->body, ($halfWidth) ? 800 : 2000));

        $dom = new \DOMDocument();
        @$dom->loadHTML($mednews->body);
        $imgtags = $dom->getElementsByTagName('img');
        if($imgtags->length > 0) {
            $cover_image = $imgtags->item(0)->getAttribute('src');
        }
        else {
            $cover_image = null;
        }

        if($halfWidth) {
            return view('doctors.mednews-pre-half', [
                'url' => $url,
                'title' => $title,
                'doctor_id' => $doctor_id,
                'doctor_name' => $doctor_name,
                'published_on' => $published_on,
                'cover_image' => $cover_image,
                'content' => $content,
            ]);
        }
        return view('doctors.mednews-pre', [
            'url' => $url,
            'title' => $title,
            'doctor_id' => $doctor_id,
            'doctor_name' => $doctor_name,
            'published_on' => $published_on,
            'cover_image' => $cover_image,
            'content' => $content,
        ]);
    }
}

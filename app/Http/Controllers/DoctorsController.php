<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Fee;
use App\Models\MedicalNews;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Helpers\Utils;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

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
			'viewerIsOwner' => (Auth::check() && Auth::user()->id == $doctor_id),
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
			'viewerIsOwner' => (Auth::check() && Auth::user()->id == $doctor_id),
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
		if(!Auth::check()) {
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

	public function ask(Request $request, $doctor_id)
	{

	}

	public function askedQuestions(Request $request)
	{

	}

	public function schedule(Request $request)
	{
		if(!Auth::check()) {
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

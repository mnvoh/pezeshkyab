<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\MedicalNews;
use Illuminate\Http\Request;
use App\Helpers\Utils;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class DoctorsController extends Controller
{
	public function __construct()
	{
		view()->share('use_doctors_navbar', true);
	}

	public function homePage(Request $request, $doctor_id)
    {
        $doctor = Doctor::where('id', $doctor_id)->firstOrFail();

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
			'name' => $doctor->name . ' ' . $doctor->lname,
			'specialty' => $doctor->specialties[0]->title,
			'specialty_title' => $doctor->specialties[0]->desc,
			'about' => $doctor->bio,
			'feed' => $med_news_rendered,
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

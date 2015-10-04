<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\MedicalNews;
use Illuminate\Http\Request;
use App\Helpers\Utils;
use App\Http\Requests;

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
			->orderBy('created_at', 'desc')
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

	public function medNews(Request $request, $medical_news_id)
	{

	}

	public function addMedNews(Request $request)
	{
		if($request->has('form-submitted')) {
			return redirect()->route("doctors.articles", [])->with('status', 'mednews_added');
		}

		return view('doctors.add-med-news');
	}


	public function ask(Request $request, $doctor_id)
	{

	}



    public function renderMedicalNews(MedicalNews $mednews,
									  $halfWidth = true )
    {
        $url = $title = $doctor_name = $doctor_id = $published_on = $cover_image = $content = "";

        $url = route('doctors.article', ['medical_news_id' => $mednews->id]);
        $title = $mednews->title;
        $doctor_id = $mednews->doctor->id;
        $doctor_name = $mednews->doctor->name . ' ' . $mednews->doctor->lname;
        $published_on = jdate('Y/m/d H:i:s', $mednews->created_at);
        $content = strip_tags(Utils::truncate($mednews->body, ($halfWidth) ? 500 : 750));

        $dom = new \DOMDocument();
        @$dom->loadHTML($mednews->body);
        $imgtags = $dom->getElementsByTagName('img');
        if(count($imgtags)) {
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

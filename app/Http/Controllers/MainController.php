<?php
namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\MedicalQuestion;
use Illuminate\Http\Request;
use App\Helpers\Utils;
use App\Models\MedicalNews;

class MainController extends Controller
{

	public function index(Request $request)
	{
		$med_news = MedicalNews::where('scope', '<>', 'self')
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

		$med_questions = MedicalQuestion::where('scope', 'public')
			->whereNotNull('response')
			->orderBy('created_at', 'desc')
			->take(3)
			->get();

		return view('main.home', array(
			'includeMainCarousel' => true,
			'includeMedicalQuestionForm' => true,
			'feed' => $med_news_rendered,
			'medical_questions' => $med_questions,
		));
	}

	public function medNews(Request $request)
	{
		$med_news = MedicalNews::where('scope', '<>', 'self')
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

		return view('main.med-news', [
			'med_news' => $med_news,
			'feed' => $med_news_rendered,
		]);
	}

    public function about() {
        return view('main.about');
    }

	public function contact() {
		return view('main.contact-us');
	}

	public function fees() {
		return view('main.fees', [
			'fees' => Fee::all(),
		]);
	}

	public function insurances() {
		return view('main.insurances');
	}

	public function medQuestions()
	{
		$questions = MedicalQuestion::paginate(10);
		return view('main.med-questions', ['questions' => $questions]);
	}

	public static function renderMedicalNews(MedicalNews $mednews, $halfWidth = true )
	{
		/***************************************************
		 * ************        ATTENSION     ***************
		 * Remember to reflect any changes you make here
		 * to DoctorsController@renderMedicalNews
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
		if ($imgtags->length > 0) {
			$cover_image = $imgtags->item(0)->getAttribute('src');
		} else {
			$cover_image = null;
		}

		if ($halfWidth) {
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

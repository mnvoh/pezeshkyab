<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Utils;

class MainController extends Controller {

	public function index(Request $request) {
		return view('main.home', array(
			'includeMainCarousel' => true,
			'includeMedicalQuestionForm' => true,
			'feed' => array(
                array(
                    'title' => 'Awareness of fertility preservation options among younger cancer '
                        . 'patients may be low',
                    'img' => 'http://cdn1.medicalnewstoday.com/content/images/articles/297/297309/'
                        . 'woman-and-doctor-talking.jpg',
                    'content' => Utils::word_safe_substr(file_get_contents(base_path() . '/news1'), 512),
					'publisher' => 'محمد محمدی',
					'publisher_id' => 12,
					'published_on' => Utils::shamsiDateFromGreg(time()),
                ),
                array(
                    'title' => "Skin cancer risk linked with grapefruit and orange juice",
                    'img' => 'http://cdn1.medicalnewstoday.com/content/images/articles/296/296087/'
                                . 'grapefruit-juice.jpg',
                    'content' => Utils::word_safe_substr(file_get_contents(base_path() . '/news2'), 256),
					'publisher' => 'محمد محمدی',
					'publisher_id' => 12,
					'published_on' => Utils::shamsiDateFromGreg(time()),
                ),
                array(
                    'title' => 'Is milk bad for you?',
                    'img' => 'http://cdn1.medicalnewstoday.com/content/images/articles/296/296564/'
                                . 'cow-and-a-jug-of-milk.jpg',
                    'content' => Utils::word_safe_substr(file_get_contents(base_path() . '/news3'), 256),
					'publisher' => 'محمد محمدی',
					'publisher_id' => 12,
					'published_on' => Utils::shamsiDateFromGreg(time()),
                )
			),
		));
	}

    public function about() {
        return view('main.about');
    }

	public function contact() {
		return view('main.contact-us');
	}

	public function fees() {
		return view('main.fees', [
			'fees' => \DbOps::getFees(),
		]);
	}

	public function insurances() {
		return view('main.insurances');
	}

}

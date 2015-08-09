<?php
namespace App\Http\Controllers;


class MainController extends Controller {

	public function index() {
		return view('main.home', array(
			'feed' => array(
                array(
                    'title' => 'Awareness of fertility preservation options among younger cancer '
                        . 'patients may be low',
                    'img' => 'http://cdn1.medicalnewstoday.com/content/images/articles/297/297309/'
                        . 'woman-and-doctor-talking.jpg',
                    'content' => \Utils::word_safe_substr(file_get_contents(base_path() . '/news1'), 512),
                ),
                array(
                    'title' => "Skin cancer risk linked with grapefruit and orange juice",
                    'img' => 'http://cdn1.medicalnewstoday.com/content/images/articles/296/296087/'
                                . 'grapefruit-juice.jpg',
                    'content' => \Utils::word_safe_substr(file_get_contents(base_path() . '/news2'), 256),
                ),
                array(
                    'title' => 'Is milk bad for you?',
                    'img' => 'http://cdn1.medicalnewstoday.com/content/images/articles/296/296564/'
                                . 'cow-and-a-jug-of-milk.jpg',
                    'content' => \Utils::word_safe_substr(file_get_contents(base_path() . '/news3'), 256),
                )
			),
		));
	}

    public function about() {
        return view('main.about');
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

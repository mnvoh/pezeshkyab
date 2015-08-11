<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class DoctorsController extends Controller
{
	public function homePage(Request $request, $doctor_id) {
		return view('doctors.homepage', [
			'doctor_id' => $doctor_id,
			'name' => 'محمد محمدی',
			'specialty' => 'cardiology',
			'specialty_title' => 'متخصص قلب و عروق',
			'about' => 'من دکتر بهروز مقدادی متخصص نوزادان، کودکان و نوجوانان دارای بورد تخصصی کودکان و عضو انجمن کودکان ایران شاغل در بخش های مختلف درمانی در بیمارستان های شهدای یافت آباد، ابن سینا و پیامبران منجمله بخش های مراقبت های ویژه نوزادانکودکان و سوختگی ، ( NICU , PICU , BURN ICU ) مفتخرم تا از طریق این سایت پاسخگوی سوالات شما عزیزان در مباحث مختلف بخصوص زمینه های کاری مورد علاقه ام در بحث اختلالات تغذیه و رشد ونمو نوزادان و کودکان و مباحث مربوط به اختلالات بلوغ زودرس و مشکلات ناشی از آن همچون کوتاهی قد و مشکلات جسمی وابسته و تغذیه در نوزادن و کودکان با شرایط خاص همچون سوختگی، نارسی و دارای بیماری های گوارشی باشم؛ همچنین تلاش خواهم نمود تا مطالبی کاربردی و شایع را که مورد سوال اغلب والدین گرامی در خصوص فرزندان عزیزشان می باشد به صورت مقاله و پی نوشت به صورت هفتگی در صفحه خود قرار دهم امیدوارم شما عزیزان با ارتباط مستمر با سایت یاری دهنده من و سایر همکارانم در این امر زیبا و ارزشمند باشید و سوالات، نظرات و نقد های سازنده خود را با من در میان بگذارید تا شاهد هرچه پر بار تر شدن سایت خود باشیم با تشکر و آرزوی سلامتی برای تمامی شما عزیزان و نونهالان دوست داشتنی سرزمینمان ایران و هر جای دنیا که نوزادی چشم به جهان می گشاید.',
			'feed' => array(
				array(
					'title' => 'Awareness of fertility preservation options among younger cancer '
						. 'patients may be low',
					'img' => 'http://cdn1.medicalnewstoday.com/content/images/articles/297/297309/'
						. 'woman-and-doctor-talking.jpg',
					'content' => \Utils::word_safe_substr(file_get_contents(base_path() . '/news1'), 512),
					'publisher' => 'محمد محمدی',
					'publisher_id' => 12,
					'published_on' => \Utils::prefDate(time(), $request->segment(1)),
				),
				array(
					'title' => "Skin cancer risk linked with grapefruit and orange juice",
					'img' => 'http://cdn1.medicalnewstoday.com/content/images/articles/296/296087/'
						. 'grapefruit-juice.jpg',
					'content' => \Utils::word_safe_substr(file_get_contents(base_path() . '/news2'), 256),
					'publisher' => 'محمد محمدی',
					'publisher_id' => 12,
					'published_on' => \Utils::prefDate(time(), $request->segment(1)),
				),
				array(
					'title' => 'Is milk bad for you?',
					'img' => 'http://cdn1.medicalnewstoday.com/content/images/articles/296/296564/'
						. 'cow-and-a-jug-of-milk.jpg',
					'content' => \Utils::word_safe_substr(file_get_contents(base_path() . '/news3'), 256),
					'publisher' => 'محمد محمدی',
					'publisher_id' => 12,
					'published_on' => \Utils::prefDate(time(), $request->segment(1)),
				)
			),
		]);
	}

	public function articles(Request $request, $doctor_id)
	{
		return view('doctors.articles', [
			'doctor_id' => $doctor_id,
			'name' => 'محمد محمدی',
			'specialty' => 'cardiology',
			'specialty_title' => 'متخصص قلب و عروق',
			'about' => 'من دکتر بهروز مقدادی متخصص نوزادان، کودکان و نوجوانان دارای بورد تخصصی کودکان و عضو انجمن کودکان ایران شاغل در بخش های مختلف درمانی در بیمارستان های شهدای یافت آباد، ابن سینا و پیامبران منجمله بخش های مراقبت های ویژه نوزادانکودکان و سوختگی ، ( NICU , PICU , BURN ICU ) مفتخرم تا از طریق این سایت پاسخگوی سوالات شما عزیزان در مباحث مختلف بخصوص زمینه های کاری مورد علاقه ام در بحث اختلالات تغذیه و رشد ونمو نوزادان و کودکان و مباحث مربوط به اختلالات بلوغ زودرس و مشکلات ناشی از آن همچون کوتاهی قد و مشکلات جسمی وابسته و تغذیه در نوزادن و کودکان با شرایط خاص همچون سوختگی، نارسی و دارای بیماری های گوارشی باشم؛ همچنین تلاش خواهم نمود تا مطالبی کاربردی و شایع را که مورد سوال اغلب والدین گرامی در خصوص فرزندان عزیزشان می باشد به صورت مقاله و پی نوشت به صورت هفتگی در صفحه خود قرار دهم امیدوارم شما عزیزان با ارتباط مستمر با سایت یاری دهنده من و سایر همکارانم در این امر زیبا و ارزشمند باشید و سوالات، نظرات و نقد های سازنده خود را با من در میان بگذارید تا شاهد هرچه پر بار تر شدن سایت خود باشیم با تشکر و آرزوی سلامتی برای تمامی شما عزیزان و نونهالان دوست داشتنی سرزمینمان ایران و هر جای دنیا که نوزادی چشم به جهان می گشاید.',
			'feed' => array(
				array(
					'title' => 'Awareness of fertility preservation options among younger cancer '
						. 'patients may be low',
					'img' => 'http://cdn1.medicalnewstoday.com/content/images/articles/297/297309/'
						. 'woman-and-doctor-talking.jpg',
					'content' => \Utils::word_safe_substr(file_get_contents(base_path() . '/news1'), 512),
					'publisher' => 'محمد محمدی',
					'publisher_id' => 12,
					'published_on' => \Utils::prefDate(time(), $request->segment(1)),
				),
				array(
					'title' => "Skin cancer risk linked with grapefruit and orange juice",
					'img' => 'http://cdn1.medicalnewstoday.com/content/images/articles/296/296087/'
						. 'grapefruit-juice.jpg',
					'content' => \Utils::word_safe_substr(file_get_contents(base_path() . '/news2'), 256),
					'publisher' => 'محمد محمدی',
					'publisher_id' => 12,
					'published_on' => \Utils::prefDate(time(), $request->segment(1)),
				),
				array(
					'title' => 'Is milk bad for you?',
					'img' => 'http://cdn1.medicalnewstoday.com/content/images/articles/296/296564/'
						. 'cow-and-a-jug-of-milk.jpg',
					'content' => \Utils::word_safe_substr(file_get_contents(base_path() . '/news3'), 256),
					'publisher' => 'محمد محمدی',
					'publisher_id' => 12,
					'published_on' => \Utils::prefDate(time(), $request->segment(1)),
				),
				array(
					'title' => 'Is milk bad for you?',
					'img' => 'http://cdn1.medicalnewstoday.com/content/images/articles/296/296564/'
						. 'cow-and-a-jug-of-milk.jpg',
					'content' => \Utils::word_safe_substr(file_get_contents(base_path() . '/news3'), 256),
					'publisher' => 'محمد محمدی',
					'publisher_id' => 12,
					'published_on' => \Utils::prefDate(time(), $request->segment(1)),
				),
				array(
					'title' => 'Is milk bad for you?',
					'img' => 'http://cdn1.medicalnewstoday.com/content/images/articles/296/296564/'
						. 'cow-and-a-jug-of-milk.jpg',
					'content' => \Utils::word_safe_substr(file_get_contents(base_path() . '/news3'), 256),
					'publisher' => 'محمد محمدی',
					'publisher_id' => 12,
					'published_on' => \Utils::prefDate(time(), $request->segment(1)),
				),
				array(
					'title' => 'Is milk bad for you?',
					'img' => 'http://cdn1.medicalnewstoday.com/content/images/articles/296/296564/'
						. 'cow-and-a-jug-of-milk.jpg',
					'content' => \Utils::word_safe_substr(file_get_contents(base_path() . '/news3'), 256),
					'publisher' => 'محمد محمدی',
					'publisher_id' => 12,
					'published_on' => \Utils::prefDate(time(), $request->segment(1)),
				),
				array(
					'title' => 'Is milk bad for you?',
					'img' => 'http://cdn1.medicalnewstoday.com/content/images/articles/296/296564/'
						. 'cow-and-a-jug-of-milk.jpg',
					'content' => \Utils::word_safe_substr(file_get_contents(base_path() . '/news3'), 256),
					'publisher' => 'محمد محمدی',
					'publisher_id' => 12,
					'published_on' => \Utils::prefDate(time(), $request->segment(1)),
				),
				array(
					'title' => 'Is milk bad for you?',
					'img' => 'http://cdn1.medicalnewstoday.com/content/images/articles/296/296564/'
						. 'cow-and-a-jug-of-milk.jpg',
					'content' => \Utils::word_safe_substr(file_get_contents(base_path() . '/news3'), 256),
					'publisher' => 'محمد محمدی',
					'publisher_id' => 12,
					'published_on' => \Utils::prefDate(time(), $request->segment(1)),
				),
				array(
					'title' => 'Is milk bad for you?',
					'img' => 'http://cdn1.medicalnewstoday.com/content/images/articles/296/296564/'
						. 'cow-and-a-jug-of-milk.jpg',
					'content' => \Utils::word_safe_substr(file_get_contents(base_path() . '/news3'), 256),
					'publisher' => 'محمد محمدی',
					'publisher_id' => 12,
					'published_on' => \Utils::prefDate(time(), $request->segment(1)),
				),
				array(
					'title' => 'Is milk bad for you?',
					'img' => 'http://cdn1.medicalnewstoday.com/content/images/articles/296/296564/'
						. 'cow-and-a-jug-of-milk.jpg',
					'content' => \Utils::word_safe_substr(file_get_contents(base_path() . '/news3'), 256),
					'publisher' => 'محمد محمدی',
					'publisher_id' => 12,
					'published_on' => \Utils::prefDate(time(), $request->segment(1)),
				),
			),
		]);
	}

	public function ask(Request $request, $doctor_id)
	{

	}
}

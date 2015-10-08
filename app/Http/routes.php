<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::any('/', ['as' => 'root', function () {
    return view('selector_page');
}]);

Route::any('/email_template', ['as' => 'email_template', function () {
	$content_en = "Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.

Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim. ";

	$content_fa = "ه گزارش خبرگزاری مهر، روابط عمومی سازمان غذا و دارو در اطلاعیه‌ای فرآورده های غذایی عصاره گیاه زعفران کارخانه نعمت الله رضایی با نام تجاری معراج، نمک با نام تجاری ماهبانو(پارسیان) و نمک تصفیه شده یددار با نام تجاری نگین را غیرمجاز و تقلبی معرفی کرد.

در این اطلاعیه همچنین محصولاتی چون آلبالو خشک، توت خشک، انجیر خشک، مغز گردو و... با نام تجاری نوکام(کامن نو)، رشته پلویی با نام تجاری هانی، ادویه جات شرکت صبا پخش میلاد با نام تجاری میلاد، دارچین با نام تجاری اکباتان تاک، سماق تک نفره با نام تجاری ارغوان، گلاب با نام تجاری ساغر گل ریزان به دلیل جعل مستندات مورد نظر اداره کل نظارت و ارزیابی فرآورده‌های غذایی، آرایشی و بهداشتی سازمان غذا و دارو غیرمجاز شمرده می شوند.

روابط عمومی سازمان غذا و دارو در ادامه با اعلان اینکه این معرفی اسامی به قصد مبارزه با ارائه محصولات غیر مجاز در سطح عرضه صورت می گیرد؛ از افرادی که محصولات نامبرده را در مراکز فروش مشاهده می‌کنند خواست که معاونت‌های غذا و داروی دانشگاه‌های علوم پزشکی سراسر کشور و نیروی انتظامی را مطلع سازند تا نسبت به جمع‌آوری آنها اقدام لازم را به عمل آورند.

";
//	return view('email.doctor-reservation', [
//		'dir' => 'ltr',
//		'float' => 'left',
//		'title' => 'Message from doctor',
//		'content' => $content_en,
//	]);

	return view('email.doctor-reservation', [
		'dir' => 'rtl',
		'float' => 'right',
		'title' => 'پیغام از طرف دکتر',
		'content' => $content_fa,
	]);
}]);


/*          MainController
  ======================================*/
Route::any('docfinder', [
    'as' => 'main.docfinder_home',
    'uses' => 'MainController@index'
]);
Route::any('docfinder/med-news', [
	'as' => 'main.med_news',
	'uses' => 'MainController@medNews'
]);
Route::any('docfinder/about', [
    'as' => 'main.about',
    'uses' => 'MainController@about'
]);
Route::any('docfinder/contact', [
    'as' => 'main.contact',
    'uses' => 'MainController@contact'
]);
Route::any('docfinder/links', [
    'as' => 'main.links',
    'uses' => 'MainController@links'
]);
Route::any('docfinder/insurances', [
    'as' => 'main.insurances',
    'uses' => 'MainController@insurances'
]);
Route::any('docfinder/fees', [
    'as' => 'main.fees',
    'uses' => 'MainController@fees'
]);
Route::any('docfinder/tos', [
	'as' => 'main.tos',
	'uses' => 'MainController@tos'
]);
Route::any('docfinder/privacy-policy', [
	'as' => 'main.privacy_policy',
	'uses' => 'MainController@privacyPolicy'
]);

/*          AuthController
  ======================================*/
Route::get('docfinder/login', [
    'as' => 'user.login',
    'uses' => 'Auth\AuthController@getLogin'
]);
Route::post('docfinder/login', [
    'as' => 'user.login',
    'uses' => 'Auth\AuthController@postLogin'
]);
Route::get('docfinder/logout', [
    'as' => 'user.logout',
    'uses' => 'Auth\AuthController@getLogout'
]);
Route::get('docfinder/register', [
    'as' => 'user.register',
    'uses' => 'Auth\AuthController@getRegister'
]);
Route::post('docfinder/register', [
    'as' => 'user.register',
    'uses' => 'Auth\AuthController@postRegister'
]);

Route::get('docfinder/register-complete', [
    'as' => 'user.register_complete',
    'uses' => 'Auth\AuthController@getRegisterComplete'
]);

Route::controllers([
    'password' => 'Auth\PasswordController',
]);


/*          SearchController
  ======================================*/
Route::any('docfinder/find', [
    'as' => 'search.find',
    'uses' => 'SearchController@find'
]);


/*          AppointmentController
  ======================================*/
Route::any('docfinder/book-appointment/{step}', [
    'as' => 'appointment.book',
    'uses' => 'AppointmentController@book'
]);

Route::any('docfinder/book-appointment/{doctor_id}/{step}', [
	'as' => 'appointment.book_for_doctor',
	'uses' => 'AppointmentController@bookForDoctor'
]);

/*          DoctorsController
  ======================================*/
Route::any('docfinder/doctors/{doctor_id}', [
	'as' => 'doctors.homepage',
	'uses' => 'DoctorsController@homePage'
])->where('doctor_id', '[0-9]+');

Route::any('docfinder/doctors/{doctor_id}/med-news', [
	'as' => 'doctors.articles',
	'uses' => 'DoctorsController@doctorsMedNews'
]);

Route::any('docfinder/med-news/{medical_news_id}/{title?}', [
    'as' => 'doctors.article',
    'uses' => 'DoctorsController@medNews'
]);

Route::any('docfinder/med-news/add', [
	'as' => 'doctors.add_med_news',
	'uses' => 'DoctorsController@addMedNews'
]);

Route::any('docfinder/doctors/ask/{doctor_id?}', [
	'as' => 'doctors.ask',
	'uses' => 'DoctorsController@ask'
]);
Route::any('docfinder/doctors/questions', [
	'as' => 'doctors.asked_questions',
	'uses' => 'DoctorsController@askedQuestions'
]);

Route::any('docfinder/doctors/schedule', [
	'as' => 'doctors.schedule',
	'uses' => 'DoctorsController@schedule'
]);

Route::any('docfinder/doctors/transactions', [
	'as' => 'doctors.transactions',
	'uses' => 'DoctorsController@transactions'
]);

Route::any('docfinder/doctors/email-patient-reservation', [
	'as' => 'doctors.email_patient_reservation',
	'uses' => 'DoctorsController@emailPatientForReservation'
]);
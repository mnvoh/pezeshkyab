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

Route::any('/index_doctors', ['as' => 'index_doctors', function () {
	$doctors = \App\Models\Doctor::all();
	foreach($doctors as $doctor) {
		echo "Rating({$doctor->id}): " . $doctor->rating() . "\n<br />";
		$doctor->indexInElasticsearch();
	}
	echo "done";
	exit;
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
Route::any('docfinder/med-questions', [
	'as' => 'main.med_questions',
	'uses' => 'MainController@medQuestions'
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
    'uses' => 'Auth\AuthController@postLogin',
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

////////////

Route::post('docfinder/alogin', [
	'as' => 'user.admin_login',
	'uses' => 'Auth\AuthController@postAdminLogin',
]);

////////////

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
Route::any('docfinder/book-appointment/{step}/{doctor_id?}', [
    'as' => 'appointment.book',
    'uses' => 'AppointmentController@book'
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
])->where('medical_news_id', '[0-9]+');

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
Route::any('docfinder/doctors/upload-avatar', [
	'as' => 'doctors.upload_avatar',
	'uses' => 'DoctorsController@uploadAvatar'
]);

Route::any('docfinder/doctors/rate', [
	'as' => 'doctors.rate',
	'uses' => 'DoctorsController@rate'
]);

/*          AdminsController
  ======================================*/
Route::get('docfinder/admin/login', [
	'as' => 'admins.login',
	'uses' => 'AdminsController@loginGet'
]);
Route::post('docfinder/admin/login', [
	'as' => 'admins.login',
	'uses' => 'AdminsController@loginPost'
]);
Route::get('docfinder/admin/logout', [
	'as' => 'admins.logout',
	'uses' => 'AdminsController@logout'
]);


Route::any('docfinder/admin', [
	'as' => 'admins.home',
	'uses' => 'AdminsController@home'
]);
Route::any('docfinder/admin/doctors', [
	'as' => 'admins.doctors',
	'uses' => 'AdminsController@doctors'
]);
Route::any('docfinder/admin/admins', [
	'as' => 'admins.admins',
	'uses' => 'AdminsController@admins'
]);
Route::any('docfinder/admin/transactions', [
	'as' => 'admins.transactions',
	'uses' => 'AdminsController@transactions'
]);
Route::any('docfinder/admin/reservations', [
	'as' => 'admins.reservations',
	'uses' => 'AdminsController@reservations'
]);
Route::any('docfinder/admin/medical-questions', [
	'as' => 'admins.medical_question',
	'uses' => 'AdminsController@medicalQuestions'
]);
Route::any('docfinder/admin/fees', [
	'as' => 'admins.fees',
	'uses' => 'AdminsController@fees'
]);
Route::any('docfinder/admin/insurances', [
	'as' => 'admins.insurances',
	'uses' => 'AdminsController@insurances'
]);
Route::any('docfinder/admin/specialties', [
	'as' => 'admins.specialties',
	'uses' => 'AdminsController@specialties'
]);
Route::any('docfinder/admin/upload-specialty-image', [
	'as' => 'admins.upload_specialty_image',
	'uses' => 'AdminsController@uploadSpecialtyImage'
]);
Route::any('docfinder/admin/hospitals', [
	'as' => 'admins.hospitals',
	'uses' => 'AdminsController@hospitals'
]);
Route::any('docfinder/admin/medical-news', [
	'as' => 'admins.medical_news',
	'uses' => 'AdminsController@medicalNews'
]);
Route::any('docfinder/admin/chats', [
	'as' => 'admins.chats',
	'uses' => 'AdminsController@chats'
]);
Route::any('docfinder/admin/links', [
	'as' => 'admins.links',
	'uses' => 'AdminsController@links'
]);
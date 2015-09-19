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

/*          MainController
  ======================================*/
Route::any('docfinder', [
    'as' => 'main.docfinder_home',
    'uses' => 'MainController@index'
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
Route::any('doctors/{doctor_id}', [
	'as' => 'doctors.homepage',
	'uses' => 'DoctorsController@homePage'
]);

Route::any('doctors/{doctor_id}/articles', [
	'as' => 'doctors.articles',
	'uses' => 'DoctorsController@articles'
]);

Route::any('doctors/{doctor_id}/ask', [
	'as' => 'doctors.ask',
	'uses' => 'DoctorsController@ask'
]);

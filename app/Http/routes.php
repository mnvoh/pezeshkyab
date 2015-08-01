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

Route::any('/', function () {
    return view('selector_page');
});

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


/*          UserController
  ======================================*/
Route::any('docfinder/login', [
    'as' => 'user.login',
    'uses' => 'UserController@login'
]);
Route::any('docfinder/register', [
    'as' => 'user.register',
    'uses' => 'UserController@register'
]);
Route::any('docfinder/forgot-password', [
    'as' => 'user.forgot_password',
    'uses' => 'UserController@forgotPassword'
]);


/*          SearchController
  ======================================*/
Route::any('docfinder/find-doctor', [
    'as' => 'search.find',
    'uses' => 'SearchController@find'
]);


/*          AppointmentController
  ======================================*/
Route::any('docfinder/book-appointment/{step}', [
    'as' => 'appointment.book',
    'uses' => 'AppointmentController@book'
]);
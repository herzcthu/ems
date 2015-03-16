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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::post('users/import', 'UsersListController@import');

Route::post('locations/import', 'GeolocationsController@import');

Route::post('participants/import', 'ParticipantsController@import');

Route::get('users/{users}/delete', 'UsersListController@destroy');

Route::get('participants/{participants}/delete', 'ParticipantsController@destroy');

Route::resource('users', 'UsersListController');

Route::resource('locations', 'GeolocationsController');

Route::resource('participants', 'ParticipantsController');

Route::post('roles', 'UserRoleController@update');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

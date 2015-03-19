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


Route::group(['prefix' => 'forms'], function(){
	Route::get('/build', 'EmsFormsController@create_question_form');

	Route::post('/build', 'EmsFormsController@save_question');

	Route::get('/{forms}/delete', 'EmsFormsController@destroy');

	Route::get('/{forms}/results', 'EmsFormsController@results');

	Route::get('/question/{forms}', 'EmsFormsController@qedit');

	Route::get('/question/{forms}/delete', 'EmsFormsController@qdestroy');

	Route::get('/{forms}/dataentry', 'EmsFormsController@dataentry_form');

	Route::post('/{forms}/dataentry', 'EmsFormsController@dataentry_save');

	Route::get('/{forms}/build', 'EmsFormsController@create_question_form');

	Route::post('/{forms}/build', 'EmsFormsController@save_question');

	Route::patch('/{forms}/build', 'EmsFormsController@qupdate');


});

Route::post('users/import', 'UsersListController@import');

Route::post('locations/import', 'GeolocationsController@import');

Route::post('participants/import', 'ParticipantsController@import');

Route::get('users/{users}/delete', 'UsersListController@destroy');



Route::get('participants/{participants}/delete', 'ParticipantsController@destroy');

Route::resource('users', 'UsersListController');

Route::resource('locations', 'GeolocationsController');

Route::resource('participants', 'ParticipantsController');

Route::resource('forms', 'EmsFormsController');

Route::post('roles', 'UserRoleController@update');

Route::get('settings', 'GeneralSettingsController@index');

Route::patch('settings', 'GeneralSettingsController@update');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
	//'forms' => 'EmsFormsController'
]);


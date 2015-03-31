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
	Route::get('/add_question', 'EmsFormsController@create_question_form');

	Route::post('/add_question', 'EmsFormsController@save_question');

	Route::get('/{forms}/delete', 'EmsFormsController@destroy');

	Route::get('/question/{forms}', 'EmsFormsController@qedit');

	Route::get('/question/{forms}/delete', 'EmsFormsController@qdestroy');

	Route::get('/{forms}/dataentry', 'EmsFormsController@dataentry_form');

	Route::post('/{forms}/dataentry', 'EmsFormsController@dataentry_save');

	Route::get('/{forms}/dataentry/{interviewee}', 'EmsFormsController@dataentry_edit');

	Route::patch('/{forms}/dataentry/{interviewee}', 'EmsFormsController@dataentry_update');

	Route::get('/{forms}/add_question', 'EmsFormsController@create_question_form');

	Route::post('/{forms}/add_question', 'EmsFormsController@save_question');

	Route::post('/question/{forms}', 'EmsFormsController@save_question');

	Route::patch('/question/{forms}', 'EmsFormsController@qupdate');

});

Route::get('/results/{forms}/details', 'EmsFormsController@results_details');

Route::get('/results/{forms}', 'EmsFormsController@results');

Route::get('/results/{forms}/export', 'EmsFormsController@export_dataentry');

Route::post('users/import', 'UsersListController@import');

Route::post('locations/import', 'GeolocationsController@import');

Route::post('participants/import', 'ParticipantsController@import');

Route::post('participants/setgroup', 'ParticipantsController@setgroup');

Route::get('users/{users}/delete', 'UsersListController@destroy');

Route::resource('participants/group', 'PGroupController');

Route::get('participants/group/{group}/delete', 'PGroupController@destroy');

Route::get('participants/{participants}/delete', 'ParticipantsController@destroy');

Route::resource('users', 'UsersListController');

Route::resource('locations', 'GeolocationsController');

Route::resource('participants', 'ParticipantsController');

Route::resource('forms', 'EmsFormsController');

Route::get('dataentry/{form}/create', 'EmsQuestionsAnswersController@create');

Route::post('dataentry/{form}/create', 'EmsQuestionsAnswersController@store');

Route::resource('dataentry/{form}', 'EmsQuestionsAnswersController');

Route::post('roles', 'UserRoleController@update');

Route::get('settings', 'GeneralSettingsController@index');

Route::patch('settings', 'GeneralSettingsController@update');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
	//'forms' => 'EmsFormsController'
]);


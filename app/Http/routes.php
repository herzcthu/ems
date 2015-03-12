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

//Route::get('users', 'UserListController@index');

//Route::get('users/add-new', 'UserListController@AddNewUser');

//Route::get('users/profile', 'UserListController@ShowProfile');

//Route::get('users/profile/{id}', 'UserListController@ShowProfile');

//Route::get('users/profile/{id}/edit', 'UserListController@EditProfile');

//Route::post('users', 'UserListController@store');
Route::get('users/{id}/delete', 'UsersListController@destroy');
Route::resource('users', 'UsersListController');
Route::post('roles', 'UserRoleController@update');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

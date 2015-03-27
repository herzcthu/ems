<?php namespace App\Services;

use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
			'agree' => 'required'
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		$new_user = User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
		]);


		if($new_user['id'] == 1)
		{
			User::find(1)->attachRole(1);
		}else{
			User::find($new_user['id'])->attachRole(4);
		}
		return $new_user;
	}

}

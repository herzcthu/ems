<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		/*
		 * 				//
				'name' => 'required:min:4',
				'email' => 'required|unique:users|email',
				'password' => 'required',
				'user_gender' => 'required',
				'dob' => 'dateformat:Y-m-d',
				'user_line_phone' => '',
				'user_mobile_phone' => 'required',
				'user_mailing_address' => 'required',
				'user_biography' => '',
		 */
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->enum('user_gender', array('M','F','U'));
			$table->date('dob');
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}

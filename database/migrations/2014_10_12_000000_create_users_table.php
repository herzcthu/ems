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
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user_image')->default('user.png');
			$table->string('name');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->string('user_gender');
			$table->date('dob');
			$table->string('user_line_phone');
			$table->string('user_mobile_phone');
			$table->string('user_mailing_address');
			$table->string('user_biography');
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

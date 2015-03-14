<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('participants', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user_image')->default('user.png');
			$table->string('name');
			$table->string('nrc_id')->unique()->index();
			$table->string('email')->unique()->index();
			$table->string('user_gender');
			$table->string('ethnicity');
			$table->enum('education_level', array('none','primary','middle','highschool','under_graduate','graduated','post_graduated'));
			$table->date('dob');
			$table->string('current_org');
			$table->string('user_line_phone');
			$table->string('user_mobile_phone');
			$table->string('user_mailing_address');
			$table->string('user_biography');
			$table->enum('participant_type', array('coordinator','enumerator','spotchecker'));
			$table->integer('parent_id')->unsigned();
			$table->rememberToken();
			$table->timestamps();
			$table->foreign('parent_id')->references('id')->on('participants')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('participants');
	}

}

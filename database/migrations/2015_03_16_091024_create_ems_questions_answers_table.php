<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmsQuestionsAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ems_questions_answers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('form_id')->unsigned()->nullable();
			$table->integer('enu_id')->unsigned()->nullable();
			$table->integer('q_id')->unsigned()->nullable();
			$table->integer('user_id')->unsigned();
			$table->integer('interviewee_id')->unique();
			$table->string('answers');
			$table->timestamps();
		});
		Schema::table('ems_questions_answers', function(Blueprint $table)
		{
			$table->foreign('form_id')->references('id')->on('ems_forms')->onDelete('cascade');
			$table->foreign('q_id')->references('id')->on('ems_form_questions')->onDelete('cascade');
			$table->foreign('enu_id')->references('id')->on('participants')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			//$table->unique(array('id','form_id','enu_id','q_id','user_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ems_questions_answers');
	}

}

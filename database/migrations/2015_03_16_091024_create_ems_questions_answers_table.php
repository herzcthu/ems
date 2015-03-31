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
			$table->integer('interviewer_id')->unsigned()->nullable();
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('interviewee_id')->unique()->unsigned()->nullable();
			$table->enum('interviewee_gender', array('M','F','U'));
			$table->integer('interviewee_age');
			$table->string('notes');
			$table->string('answers');
			$table->timestamps();
		});
		Schema::table('ems_questions_answers', function(Blueprint $table)
		{
			$table->foreign('form_id')->references('id')->on('ems_forms')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
			$table->foreign('interviewer_id')->references('participant_id')->on('participants')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ems_questions_answers', function($table)
		{
			$table->dropForeign('ems_questions_answers_user_id_foreign');
		});
		Schema::drop('ems_questions_answers');

	}

}

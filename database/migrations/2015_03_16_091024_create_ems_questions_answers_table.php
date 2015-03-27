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
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('interviewee_id');
			$table->enum('interviewee_gender', array('M','F','U'));
			$table->integer('interviewee_age');
			$table->integer('interviewee_villageid')->unsigned()->nullable();
			$table->string('answers');
			$table->timestamps();
		});
		Schema::table('ems_questions_answers', function(Blueprint $table)
		{
			$table->foreign('form_id')->references('id')->on('ems_forms')->onDelete('cascade');
			$table->foreign('q_id')->references('id')->on('ems_form_questions')->onDelete('cascade');
			$table->foreign('enu_id')->references('id')->on('participants')->onDelete('set null');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
			$table->foreign('interviewee_villageid')->references('id')->on('villages')->onDelete('set null');
			$table->unique(array('q_id','interviewee_id'));
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
		Schema::table('ems_questions_answers', function($table)
		{
			$table->dropForeign('ems_questions_answers_user_id_foreign');
			$table->dropForeign('constraint ems_questions_answers_interviewee_villageid_foreign');
		});
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpotCheckerAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('spot_checker_answers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('form_id')->unsigned()->nullable();
			$table->integer('enumerator_form_id')->unsigned()->nullable();
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('psu');
			$table->integer('spotchecker_id')->unsigned()->nullable();
			$table->boolean('form_complete');
			$table->boolean('accuracy');
			$table->text('notes');
			$table->text('answers');
			$table->timestamps();
		});
		Schema::table('spot_checker_answers', function(Blueprint $table)
		{
			$table->foreign('form_id')->references('id')->on('ems_forms')->onDelete('cascade');
			$table->foreign('enumerator_form_id')->references('interviewee_id')->on('ems_questions_answers')->onDelete('set null');
			$table->foreign('spotchecker_id')->references('participant_id')->on('participants')->onDelete('set null');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('spot_checker_answers');
	}

}

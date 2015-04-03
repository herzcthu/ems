<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnumeratorsAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/*
		Schema::create('enumerators_answers', function(Blueprint $table)
		{
			$table->integer('participant_id')->unsigned()->index();
			$table->integer('answer_id')->unsigned()->index();
			$table->timestamps();
			$table->foreign('participant_id')->references('id')->on('participants')->onDelete('cascade');
			$table->foreign('answer_id')->references('interviewee_id')->on('ems_questions_answers')->onDelete('cascade');
		});
		*/
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		//Schema::drop('enumerators_answers');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmsFormQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ems_form_questions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('parent_id')->unsigned()->nullable();
			$table->integer('form_id')->unsigned()->nullable();
			$table->string('question_number');
			$table->string('question')->unique();
			$table->enum('q_type',array('single', 'main', 'sub'));
			$table->enum('input_type', array('none','same','radio','choice','select','text','textarea'));
			$table->string('a_view');
			$table->string('answers');
			$table->timestamps();
		});
		Schema::table('ems_form_questions', function(Blueprint $table)
		{
			$table->foreign('parent_id')->references('id')->on('ems_form_questions')->onDelete('cascade');
			$table->foreign('form_id')->references('id')->on('ems_forms')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ems_form_questions');
		Schema::table('ems_form_questions', function ($table)
		{
			$table->dropForeign('ems_form_questions_parent_id_foreign');
			$table->dropForeign('ems_form_questions_form_id_foreign');
		});

	}

}

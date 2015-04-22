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
			$table->integer('list_id');
			$table->string('question_number');
			$table->text('question');
			$table->enum('q_type',array('single', 'main', 'sub', 'same', 'spotchecker'));
			$table->enum('input_type', array('none','same','radio','choice','select','text','textarea','date','year','month','time'));
			$table->string('a_view');
			$table->text('answers');
			$table->timestamps();
		});
		Schema::table('ems_form_questions', function(Blueprint $table)
		{
			$table->foreign('parent_id')->references('id')->on('ems_form_questions')->onDelete('cascade');
			$table->foreign('form_id')->references('id')->on('ems_forms')->onDelete('cascade');
			$table->unique(['form_id', 'list_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		Schema::table('ems_form_questions', function ($table)
		{
			$table->dropForeign('ems_form_questions_parent_id_foreign');
			$table->dropForeign('ems_form_questions_form_id_foreign');
		});
		Schema::drop('ems_form_questions');

	}

}

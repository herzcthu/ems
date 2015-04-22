<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('form_types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('form_id')->unsigned()->index();
			$table->integer('question_id')->unsigned()->index();
			$table->timestamps();
			$table->foreign('form_id')->references('id')->on('ems_forms')->onDelete('cascade');
			$table->foreign('question_id')->references('id')->on('ems_form_questions')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('form_types');
	}

}

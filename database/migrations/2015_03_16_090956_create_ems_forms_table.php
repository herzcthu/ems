<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmsFormsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ems_forms', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('type');
			$table->integer('pgroup_id')->unsigned()->index();
			$table->integer('enu_form_id')->unsigned()->nullable()->index();
			$table->string('q_prefix');
			$table->integer('no_of_answers');
			$table->string('descriptions');
			$table->date('start_date');
			$table->date('end_date');
			$table->timestamps();
		});
		Schema::table('ems_forms', function(Blueprint $table)
		{
			$table->foreign('pgroup_id')->references('id')->on('p_groups')->onDelete('cascade');
			$table->foreign('enu_form_id')->references('id')->on('ems_forms')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ems_forms');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('districts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('district_id');
			$table->integer('states_id')->unsigned()->index();
			$table->string('district');
			$table->timestamps();
			$table->foreign('states_id')->references('id')->on('states')->onDelete('cascade');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('districts');
	}

}

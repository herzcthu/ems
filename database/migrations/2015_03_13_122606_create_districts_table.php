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
		Schema::create('coordinators_regions', function(Blueprint $table)
		{ //Coordinator Geolocation
			$table->increments('id');
			$table->integer('coordinators_id')->unsigned()->index();
			$table->integer('region_id')->unsigned()->index();
			$table->foreign('coordinators_id')->references('id')->on('participants')->onDelete('cascade');
			$table->foreign('region_id')->references('id')->on('districts')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('coordinators_regions');
		Schema::drop('districts');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ParticipantsRelations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coordinators_regions', function(Blueprint $table)
		{ //Coordinator Geolocation
			$table->increments('id');
			$table->integer('coordinators_id')->unsigned()->index();
			$table->integer('region_id')->unsigned()->index();
			$table->foreign('coordinators_id')->references('id')->on('participants')->onDelete('cascade');
			$table->foreign('region_id')->references('id')->on('districts')->onDelete('cascade');
			$table->timestamps();
		});

		Schema::create('enumerators_villages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('villages_id')->unsigned()->index();
			$table->integer('enumerators_id')->unsigned()->index();
			$table->timestamps();
			$table->foreign('villages_id')->references('id')->on('villages')->onDelete('cascade');
			$table->foreign('enumerators_id')->references('id')->on('participants')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('coordinators_regions');
		Schema::drop('enumerators_villages');
	}

}

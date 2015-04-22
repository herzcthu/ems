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

		Schema::create('coordinators_states', function(Blueprint $table)
		{ //Coordinator Geolocation
			$table->increments('id');
			$table->integer('coordinators_id')->unsigned()->index();
			$table->integer('state_id')->unsigned()->index();
			$table->foreign('coordinators_id')->references('id')->on('participants')->onDelete('cascade');
			$table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
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
		Schema::create('spotcheckers_townships', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('townships_id')->unsigned()->index();
			$table->integer('spotcheckers_id')->unsigned()->index();
			$table->timestamps();
			$table->foreign('townships_id')->references('id')->on('townships')->onDelete('cascade');
			$table->foreign('spotcheckers_id')->references('id')->on('participants')->onDelete('cascade');
		});

		Schema::create('participants_geolocations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('location_id')->unsigned()->nullable()->index();
			$table->integer('participant_id')->unsigned()->nullable()->index();
			$table->integer('pace_id')->unique();
			$table->timestamps();
			$table->foreign('location_id')->references('id')->on('geolocations')->onDelete('cascade');
			$table->foreign('participant_id')->references('id')->on('participants')->onDelete('cascade');
		});

		Schema::create('participants_relations', function(Blueprint $table)
		{
			$table->integer('parent_id')->unsigned()->nullable()->index();
			$table->integer('child_id')->unsigned()->nullable()->index();
			$table->timestamps();
			$table->foreign('parent_id')->references('id')->on('participants')->onDelete('cascade');
			$table->foreign('child_id')->references('id')->on('participants')->onDelete('cascade');
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
		Schema::drop('coordinators_states');
		Schema::drop('enumerators_villages');
		Schema::drop('spotcheckers_townships');
		Schema::drop('participants_geolocations');
		//Schema::drop('participants_relations');
	}

}

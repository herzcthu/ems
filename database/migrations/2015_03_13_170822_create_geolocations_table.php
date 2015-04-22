<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeolocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('geolocations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('parent_id')->nullable()->unsigned();
			$table->integer('location_name');
			$table->integer('location_type');
			$table->foreign('parent_id')->references('id')->on('geolocations')->onDelete('set null');
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
		Schema::drop('geolocations');
	}

}

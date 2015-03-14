<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTownshipsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('townships', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('districts_id')->unsigned()->index();
			$table->string('township');
			$table->timestamps();
			$table->foreign('districts_id')->references('id')->on('districts')->onDelete('cascade');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('townships');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('villages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('townships_id')->unsigned()->index();
			$table->integer('village_id');
			$table->string('villagetrack')->nullable();
			$table->string('village');
			$table->string('village_my')->nullable();
			$table->timestamps();
			$table->foreign('townships_id')->references('id')->on('townships')->onDelete('cascade');
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
		Schema::drop('enumerators_villages');
		Schema::drop('villages');
	}

}

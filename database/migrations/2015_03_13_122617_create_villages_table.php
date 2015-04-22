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
			$table->integer('village_id')->unique();
			$table->string('villagetrack')->nullable();
			$table->string('village');
			$table->string('village_my')->nullable();
			$table->timestamps();
			$table->foreign('townships_id')->references('id')->on('townships')->onDelete('cascade');
			$table->unique(array('townships_id', 'villagetrack','village'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('villages');
	}

}

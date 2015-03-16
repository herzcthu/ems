<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('participant_types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->integer('participant_id')->unsigned();
			$table->timestamps();
			$table->foreign('participant_id')->references('id')->on('participants')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('participant_types');
	}

}

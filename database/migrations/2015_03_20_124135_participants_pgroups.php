<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ParticipantsPgroups extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('participants_pgroups', function(Blueprint $table)
		{
			$table->integer('participant_id')->unsigned()->index();
			$table->integer('pgroups_id')->unsigned()->index();
			$table->timestamps();
			$table->foreign('participant_id')->references('id')->on('participants')->onDelete('cascade');
			$table->foreign('pgroups_id')->references('id')->on('p_groups')->onDelete('cascade');
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
		Schema::drop('participants_pgroups');
	}

}

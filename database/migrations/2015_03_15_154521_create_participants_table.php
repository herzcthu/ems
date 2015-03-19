<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('participants', function(Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->integer('parent_id')->unsigned()->nullable();

      // Add needed columns here (f.ex: name, slug, path, etc.)
      $table->string('user_image')->default('user.png');
      $table->string('name');
      $table->string('nrc_id')->unique()->index();
      $table->string('email')->unique()->index();
      $table->string('user_gender');
      $table->string('ethnicity');
      $table->enum('education_level', array('none','primary','middle','highschool','under_graduate','graduated','post_graduated'));
      $table->date('dob');
      $table->string('current_org');
      $table->string('user_line_phone')->nullable();
      $table->string('user_mobile_phone')->nullable();
      $table->string('user_mailing_address')->nullable();
      $table->string('user_biography')->nullable();
      $table->string('participant_type');
      $table->timestamps();
    });

    Schema::table('participants', function(Blueprint $table)
    {
      $table->foreign('parent_id')->references('id')->on('participants')->onDelete('SET NULL');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::drop('participants');
  }

}

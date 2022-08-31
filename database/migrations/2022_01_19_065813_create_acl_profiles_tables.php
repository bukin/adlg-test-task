<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateACLProfilesTables.
 */
class CreateACLProfilesTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
       Schema::create('users_profiles', function (Blueprint $table) {
           $table->increments('id');
           $table->integer('user_id')->unsigned()->default(0)->index();
           $table->json('additional_info');
           $table->timestamps();
           $table->softDeletes();
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('users_profiles');
    }
}

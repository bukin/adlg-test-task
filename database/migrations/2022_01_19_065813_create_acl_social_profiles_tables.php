<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateACLSocialProfilesTables.
 */
class CreateACLSocialProfilesTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users_socials_profiles', function (Blueprint $table) {
           $table->increments('id');
           $table->integer('user_id')->unsigned()->default(0)->index();
           $table->string('provider');
           $table->string('provider_id');
           $table->string('provider_email');
           $table->timestamps();
           $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('users_socials_profiles');
    }
}

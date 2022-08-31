<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferralsColumnsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_hash')->after('id')->unique();
            $table->unsignedBigInteger('referrer_id')->nullable()->after('id')->index();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_hash');
            $table->dropColumn('referrer_id');
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('products_package_vendors')) {
            Schema::create('products_package_vendors', function (Blueprint $table) {
                $table->uuid('id')->index();
                $table->string('name');
                $table->string('code')->index();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('products_package_vendors');
    }
};

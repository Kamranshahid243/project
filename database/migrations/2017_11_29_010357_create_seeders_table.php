<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeedersTable extends Migration
{
    public function up()
    {
        Schema::create('seeders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('class');
            $table->dateTime('ran_at');
        });
    }

    public function down()
    {
        Schema::drop('seeders');
    }
}

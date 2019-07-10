<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWidgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widgets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('color');
            $table->string('template_url');
            $table->boolean('enabled')->default(1);
            $table->boolean('locked')->default(0);
            $table->integer('row')->nullable();
            $table->integer('col')->nullable();
            $table->integer('size_x');
            $table->integer('min_size_x')->nullable();
            $table->integer('max_size_x')->nullable();
            $table->integer('size_y');
            $table->integer('min_size_y')->nullable();
            $table->integer('max_size_y')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('widgets');
    }
}

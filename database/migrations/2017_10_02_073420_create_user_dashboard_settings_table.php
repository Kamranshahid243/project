<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDashboardSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('user_dashboard_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->text('settings');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('user_dashboard_settings');
    }
}

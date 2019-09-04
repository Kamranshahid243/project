<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id');
            $table->integer('shop_id');
            $table->integer('purchase_id');
            $table->integer('product_category');
            $table->string('product_name');
            $table->string('product_code');
            $table->string('product_description');
            $table->integer('available_quantity');
            $table->integer('unit_price');
            $table->enum('product_status',['Available','Unavailable']);
            $table->date('date');
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
        //
    }
}

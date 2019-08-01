<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::drop('purchases');
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id');
            $table->integer('vendor_id');
            $table->string('product_name');
            $table->integer('quantity');
            $table->integer('original_cost');
            $table->integer('purchase_cost');
            $table->integer('customer_cost');
            $table->integer('paid');
            $table->integer('payable');
            $table->integer('total');
            $table->date('date');
            $table->rememberToken();
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

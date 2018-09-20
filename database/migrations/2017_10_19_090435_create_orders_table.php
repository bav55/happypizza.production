<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('name');
            $table->string('phone');
            $table->string('email');

            $table->integer('delivery_type_id')->unsigned()->nullable();
            $table->foreign('delivery_type_id')->references('id')->on('delivery__types')->onDelete('cascade');

            $table->integer('delivery_zone_id')->unsigned()->nullable();
            $table->foreign('delivery_zone_id')->references('id')->on('delivery__zones')->onDelete('cascade');

            $table->longText('delivery_address');

            $table->integer('pay_type_id')->unsigned()->nullable();
            $table->foreign('pay_type_id')->references('id')->on('pay__types')->onDelete('cascade');

            $table->longText('extra');

            $table->boolean('is_paid')->default(false);

            $table->longText('good_list');

            $table->longText('present_list')->nullable();

            $table->integer('bonus_sum');

            $table->integer('apply_bonus_sum');

            $table->string('order_id');

            $table->string('transaction_id')->nullable();

            $table->integer('order_sum');

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
        Schema::dropIfExists('orders');
    }
}

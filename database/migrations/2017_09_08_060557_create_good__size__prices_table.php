<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodSizePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good__size__prices', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('good_id')->unsigned();
            $table->foreign('good_id')->references('id')->on('goods')->onDelete('cascade');

            $table->integer('portion_id')->unsigned();
            $table->foreign('portion_id')->references('id')->on('portions')->onDelete('cascade');

            $table->integer('portion_price');

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
        Schema::dropIfExists('good__size__prices');
    }
}

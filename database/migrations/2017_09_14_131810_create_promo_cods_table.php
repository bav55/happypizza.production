<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoCodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_cods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->integer('limit');
            $table->integer('sum');
            $table->boolean('is_percent')->default(false);
            $table->boolean('is_sum')->default(false);
            $table->string('comment')->nullable();
            $table->integer('apply')->default('0');
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
        Schema::dropIfExists('promo_cods');
    }
}

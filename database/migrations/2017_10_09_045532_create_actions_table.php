<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('url')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->text('image')->nullable();
            $table->dateTime('date_at')->nullable();
            $table->dateTime('date_to')->nullable();
            $table->longText('action')->nullable();
            $table->boolean('is_sum')->default(false);
            $table->boolean('is_percent')->default(false);
            $table->boolean('is_present')->default(false);
            $table->longText('total')->nullable();
            $table->boolean('show_main')->default(false);
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
        Schema::dropIfExists('actions');
    }
}

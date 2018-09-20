<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoteListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vote_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vote_id')->unsigned()->nullable();
            $table->foreign('vote_id')->references('id')->on('votes')->onDelete('cascade');
            $table->integer('vote')->nullable();
            $table->string('title');
            $table->integer('sort')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vote_lists');
    }
}

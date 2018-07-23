<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->string('location_1')->nullable();
            $table->string('location_2')->nullable();
            $table->string('location_3')->nullable();
            $table->string('location_4')->nullable();
            $table->string('location_5')->nullable();
            $table->string('location_6')->nullable();
            $table->string('location_7')->nullable();
            $table->string('location_8')->nullable();
            $table->string('location_9')->nullable();
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
        Schema::dropIfExists('games');
    }
}

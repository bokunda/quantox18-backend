<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('game_id');
            $table->integer('user_one');
            $table->integer('user_two');
            $table->boolean('user_two_accepted')->default(false);
            $table->integer('winner')->nullable();
            $table->timestamps();
    
            $table->foreign('game_id')->references('id')->on('games')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_users');
    }
}

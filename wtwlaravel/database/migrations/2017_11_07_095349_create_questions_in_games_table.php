<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsInGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions_in_games', function (Blueprint $table) {
            $table->primary(['questionId', 'gameId']);
            $table->unsignedInteger('questionId');
            $table->unsignedInteger('gameId');
            $table->boolean('isAnswered');
            $table->foreign('questionId')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('gameId')->references('id')->on('games')->onDelete('cascade');
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
        Schema::dropIfExists('questions_in_games');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamePredictionsTable extends Migration
{
    public function up()
    {
        Schema::create('game_predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->string('color'); // red, green, orange
            $table->timestamp('predicted_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('game_predictions');
    }
}


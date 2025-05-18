<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class GameGroupItem extends Model
{
    public function up()
    {
        Schema::create('game_group_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_group_id')->constrained()->onDelete('cascade');
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function gameGroup()
    {
        return $this->belongsTo(GameGroup::class);
    }

}

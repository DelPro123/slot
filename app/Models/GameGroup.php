<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class GameGroup extends Model
{
   public function up()
        {
            Schema::create('game_groups', function (Blueprint $table) {
            $table->id();
            $table->string('color'); // green, orange, red
            $table->timestamps();
        });
        // Pivot table
        Schema::create('game_group_game', function (Blueprint $table) {
            $table->foreignId('game_group_id')->constrained();
            $table->foreignId('game_id')->constrained();
            $table->primary(['game_group_id', 'game_id']);
        });
        }
    public function items()
        {
            return $this->hasMany(GameGroupItem::class);
        }


}

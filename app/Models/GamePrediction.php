<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GamePrediction extends Model
{
    protected $fillable = ['game_id', 'color', 'predicted_at'];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}

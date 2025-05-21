<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GamePrediction extends Model
{
    

    protected $fillable = [
        'game_id',
        'color',
        'predicted_at',
    ];

    protected $casts = [
        'predicted_at' => 'datetime', // ensures it's treated as Carbon instance
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}

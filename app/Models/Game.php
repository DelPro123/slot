<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    // Fields that can be mass-assigned
    protected $fillable = [   
        'provider',
        'name',
        'image_url',
    ];

    /**
     * Relationship: a game can have many predictions
     */
    public function predictions(): HasMany
    {
        return $this->hasMany(GamePrediction::class);
    }
}

<?php

use App\Http\Controllers\GameGroupController;
use Illuminate\Support\Facades\Route;
use App\Models\GameGroup;
use App\Models\Game;
use Illuminate\Support\Facades\Schema;
use Illuminate\Container\Attributes\DB;



// Group generation endpoint
Route::get('/generate-group', [GameGroupController::class, 'generate'])
    ->middleware('db.transaction'); // Wrap in database transaction

// Get all game groups with their games
Route::get('/group-list', function () {
    try {
        return GameGroup::with(['games' => function($query) {
            $query->select('games.id', 'games.name', 'games.image_url as image');
        }])
        ->latest()
        ->get()
        ->map(function($group) {
            return [
                'id' => $group->id,
                'color' => $group->color,
                'games' => $group->games,
                'created_at' => $group->created_at
            ];
        });
    } catch (\Exception $e) {
        return response()->json(['error' => 'Server error'], 500);
    }
});

// Get all available games

Route::get('/games', function() {
    return Game::orderBy('name')->get();
});

// Debug endpoint for testing relationships

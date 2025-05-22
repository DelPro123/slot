<?php

use Illuminate\Support\Facades\Route;
use App\Models\Game;
use App\Models\GamePrediction;
use App\Http\Controllers\GamePredictionController;

Route::get('/games', function () {
    return Game::orderBy('name')->get();
});


Route::get('/latest-predicted-games', function () {
    try {
        $latestTime = GamePrediction::orderByDesc('predicted_at')->first()?->predicted_at;

        if (!$latestTime) {
            return response()->json([]);
        }

        $games = GamePrediction::with('game')
            ->where('predicted_at', $latestTime)
            ->orderBy('color') // optional: sort by color
            ->get();

        return response()->json($games);
    } catch (\Throwable $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});


Route::get('/prediction-history', function () {
    try {
        $predictions = GamePrediction::with('game')
            ->orderByDesc('predicted_at')
            ->orderBy('color') // optional
            ->take(1000) // adjust or use paginate() if needed
            ->get();

        $grouped = $predictions->groupBy(function ($item) {
            return $item->predicted_at->toDateTimeString();
        });

        return response()->json($grouped);
    } catch (\Throwable $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});


Route::get('/next-prediction-time', [GamePredictionController::class, 'nextPredictionTime']);

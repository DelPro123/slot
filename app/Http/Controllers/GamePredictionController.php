<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class GamePredictionController extends Controller
{
    public function nextPredictionTime()
    {
        // Get now in UK timezone
        $ukNow = Carbon::now('Europe/London');

        // Find next 6AM or 6PM slot
        $hour = $ukNow->hour;

        if ($hour < 6) {
            $nextPrediction = $ukNow->copy()->startOfDay()->addHours(6);
        } elseif ($hour < 18) {
            $nextPrediction = $ukNow->copy()->startOfDay()->addHours(18);
        } else {
            $nextPrediction = $ukNow->copy()->addDay()->startOfDay()->addHours(6);
        }

        return response()->json([
            'next_prediction_at' => $nextPrediction->toIso8601String(),
        ]);
    }
}

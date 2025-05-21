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

        $predictionHours = [1, 16, 20]; // 1AM, 4PM, 8PM UK time
        $currentHour = $ukNow->hour;

        // Find the next prediction time slot after current hour
        $nextPrediction = null;
        foreach ($predictionHours as $hour) {
            if ($currentHour < $hour) {
                $nextPrediction = $ukNow->copy()->startOfDay()->addHours($hour);
                break;
            }
        }

        // If no slot left today, use the first slot next day
        if (!$nextPrediction) {
            $nextPrediction = $ukNow->copy()->addDay()->startOfDay()->addHours($predictionHours[0]);
        }

        return response()->json([
            'next_prediction_at' => $nextPrediction->toIso8601String(),
        ]);
    }
}

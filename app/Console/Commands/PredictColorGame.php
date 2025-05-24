<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\GamePrediction;
use App\Models\Game;

class PredictColorGame extends Command
// {
//     protected $signature = 'games:predict-color';
//     protected $description = 'Assign 10 random games to each of 3 colors (green, red, orange) every minute';

//     public function handle()
//     {
//         // Get current time in UK timezone
//         $ukNow = Carbon::now('Europe/London');
//         $minute = $ukNow->format('Y-m-d H:i'); // Format to minute level to ensure uniqueness for each minute

//         // Check if prediction already exists for the current minute
//         $start = $ukNow->copy()->startOfMinute();
//         $end = $ukNow->copy()->endOfMinute();

//         $alreadyPredicted = GamePrediction::whereBetween('predicted_at', [$start, $end])->exists();

//         if ($alreadyPredicted) {
//             $this->info("Prediction already generated for this minute: {$minute}");
//             return;
//         }

//         // Fetch 30 unique random games
//         $games = Game::inRandomOrder()->limit(30)->get();

//         if ($games->count() < 30) {
//             $this->error("Not enough games available. Need at least 30.");
//             return;
//         }

//         $colors = ['red', 'green', 'orange'];

//         // Assign 10 games to each color
//         foreach ($colors as $index => $color) {
//             $subset = $games->slice($index * 10, 10);

//             foreach ($subset as $game) {
//                 GamePrediction::create([
//                     'game_id' => $game->id,
//                     'color' => $color,
//                     'predicted_at' => $ukNow,
//                 ]);
//             }

//             $this->info("Assigned 10 games to color: $color.");
//         }

        
//         $this->info("Prediction created at {$ukNow->toDateTimeString()} (UK time).");
//     }
// }

{
    protected $signature = 'games:predict-color';
    protected $description = 'Assign 10 random games to each of 3 colors (green, red, orange) at 1AM, 4PM & 8PM UK time';

    public function handle()
    {
        // Carbon::setTestNow(Carbon::createFromTime(16, 0, 0, 'Europe/London'));
        $ukNow = Carbon::now('Europe/London');
        $hour = $ukNow->hour;

        //Allowed prediction hours: 1AM, 4PM, 8PM
        $validHours = [1, 4, 20];

        if (!in_array($hour, $validHours)) {
            $this->info("Current time is not within the allowed prediction hours (1AM, 4PM, 8PM). Skipping.");
            return;
        }

        // Check if prediction already exists in the current hour
        $start = $ukNow->copy()->startOfHour();
        $end = $ukNow->copy()->endOfHour();

        $alreadyPredicted = GamePrediction::whereBetween('predicted_at', [$start, $end])->exists();

        if ($alreadyPredicted) {
            $this->info("Prediction already generated for this hour.");
            return;
        }

        // Fetch 30 unique random games
        $games = Game::inRandomOrder()->limit(30)->get();

        if ($games->count() < 30) {
            $this->error("Not enough games available. Need at least 30.");
            return;
        }

        $colors = ['red', 'green', 'orange'];

        foreach ($colors as $index => $color) {
            $subset = $games->slice($index * 10, 10);

            foreach ($subset as $game) {
                GamePrediction::create([
                    'game_id' => $game->id,
                    'color' => $color,
                    'predicted_at' => $ukNow,
                ]);
            }

            $this->info("Assigned 10 games to color: $color.");
        }

        $this->info("Prediction created at {$ukNow->toDateTimeString()} (UK time).");
    }
}

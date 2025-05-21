<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\GamePrediction;
use App\Models\Game;

class PredictColorGame extends Command
{
    protected $signature = 'games:predict-color';
    protected $description = 'Assign 10 random games to each of 3 colors (green, red, orange) at 6AM & 6PM UK time';

    public function handle()
    {
        $ukNow = Carbon::now('Europe/London');
        $hour = $ukNow->hour;

        // Determine time slot and range
        if ($hour >= 0 && $hour < 12) {
            $slot = '6AM';
            $startHour = 6;
            $endHour = 11;
        } else {
            $slot = '6PM';
            $startHour = 18;
            $endHour = 23;
        }

        // Prevent duplicate predictions in the same slot
        $existing = GamePrediction::whereBetween('predicted_at', [
            $ukNow->copy()->startOfDay()->addHours($startHour),
            $ukNow->copy()->startOfDay()->addHours($endHour)->endOfHour(),
        ])->exists();

        if ($existing) {
            $this->info("Prediction already generated for $slot slot today.");
            return;
        }

        // Get 30 unique random games
        $totalGamesNeeded = 30;
        $availableGames = Game::inRandomOrder()->limit($totalGamesNeeded)->get();

        if ($availableGames->count() < $totalGamesNeeded) {
            $this->error("Not enough games available. Need at least $totalGamesNeeded.");
            return;
        }

        $colors = ['red', 'green', 'orange'];

        // Assign 10 random games per color
        foreach ($colors as $index => $color) {
            $gamesForColor = $availableGames->slice($index * 10, 10);

            foreach ($gamesForColor as $game) {
                GamePrediction::create([
                    'game_id' => $game->id,
                    'color' => $color,
                    'predicted_at' => $ukNow,
                ]);
            }

            $this->info("Assigned 10 games to color: $color.");
        }

        $this->info("Prediction created for $slot slot at $ukNow.");
    }
}

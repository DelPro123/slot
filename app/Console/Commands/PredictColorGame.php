<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\GamePrediction;
use App\Models\Game;

class PredictColorGame extends Command
{
    // Command signature and description
    protected $signature = 'games:predict-color';
    protected $description = 'Assign 10 random games to a single color (6AM & 6PM UK time)';

    public function handle()
    {
        $ukNow = Carbon::now('Europe/London');
        $hour = $ukNow->hour;

        // Define slot and corresponding start/end hours
        if ($hour >= 0 && $hour < 12) {
            $slot = '6AM';
            $startHour = 6;
            $endHour = 11;  // 6AM to 11:59AM
        } else {
            $slot = '6PM';
            $startHour = 18;
            $endHour = 23;  // 6PM to 11:59PM
        }

        // Check if a prediction exists in this slot today
        $existing = GamePrediction::whereBetween('predicted_at', [
            $ukNow->copy()->startOfDay()->addHours($startHour),
            $ukNow->copy()->startOfDay()->addHours($endHour)->endOfHour(),
        ])->exists();

        if ($existing) {
            $this->info("Prediction already generated for $slot slot today.");
            return;
        }

        // Select a random color and 10 random games
        $color = collect(['red', 'green', 'orange'])->random();
        $selectedGames = Game::inRandomOrder()->limit(10)->get();

        // Create predictions for the selected games
        foreach ($selectedGames as $game) {
            GamePrediction::create([
                'game_id' => $game->id,
                'color' => $color,
                'predicted_at' => $ukNow,
            ]);
        }

        // Log the successful prediction creation
        $this->info("Prediction created for $slot slot at $ukNow with color: $color.");
        $this->info("✅ games:predict-color executed at " . now());
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\GamePrediction;
use App\Models\Game;
class PredictColorGame extends Command
{
    protected $signature = 'games:predict-color';
    protected $description = 'Assign 10 random games to a single color (1AM & 1PM UK time)';

    public function handle()
    {
        $ukNow = Carbon::now('Europe/London');
        $hour = $ukNow->hour;
        $slot = $hour < 12 ? 'AM' : 'PM';

        // Check if a prediction already exists in this time slot today
        $existing = GamePrediction::whereBetween('predicted_at', [
            $ukNow->copy()->startOfDay()->addHours($slot === 'AM' ? 0 : 12),
            $ukNow->copy()->startOfDay()->addHours($slot === 'AM' ? 11 : 23),
        ])->exists();

        if ($existing) {
            $this->info("Prediction already generated for $slot slot.");
            return;
        }

        $color = collect(['red', 'green', 'orange'])->random();
        $selectedGames = Game::inRandomOrder()->limit(10)->get();

        foreach ($selectedGames as $game) {
            GamePrediction::create([
                'game_id' => $game->id,
                'color' => $color,
                'predicted_at' => $ukNow,
            ]);
        }

        $this->info("Prediction created for $slot slot at $ukNow with color: $color.");
    }
}

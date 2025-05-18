<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GameGroup;
use App\Models\Game;

class RandomizeGameGroups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:randomize-game-groups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
        {
            $colors = ['green', 'orange', 'red'];
            $games = Game::inRandomOrder()->limit(10)->get();

            $group = GameGroup::create([
                'color' => $colors[array_rand($colors)],
                'generated_at' => now('Europe/London'),
            ]);

            foreach ($games as $game) {
                $group->games()->attach($game->id);
            }

            $this->info("Game group generated at " . now('Europe/London'));
        }
}

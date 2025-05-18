<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameGroup;
use App\Models\GameGroupItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class GameGroupController extends Controller
{
    private const COLORS = ['green', 'orange', 'red'];
    private const GAMES_LIMIT = 10;
    private const TIMEZONE = 'Europe/London';

    public function generate()
    {
        $games = Game::inRandomOrder()->limit(self::GAMES_LIMIT)->get();

        if ($games->count() < self::GAMES_LIMIT) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough games available'
            ], 422);
        }

        try {
            DB::transaction(function () use ($games) {
                $group = GameGroup::create([
                    'color' => $this->getRandomColor(),
                    'generated_date' => $this->currentDate(),
                ]);

                $games->each(function ($game) use ($group) {
                    GameGroupItem::create([
                        'game_group_id' => $group->id,
                        'game_id' => $game->id,
                    ]);
                });
            });

            return response()->json([
                'success' => true,
                'message' => 'Game group generated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate game group',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function list()
    {
        try {
            $groups = GameGroup::where('generated_date', $this->currentDate())
                ->with('items.game')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $groups
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve game groups',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function getRandomColor(): string
    {
        return self::COLORS[array_rand(self::COLORS)];
    }

    private function currentDate(): string
    {
        return Carbon::now(self::TIMEZONE)->toDateString();
    }
}

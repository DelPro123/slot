<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        // Register your custom commands here
    ];

    protected function schedule(Schedule $schedule)
    {
        // Game group generation (twice daily)
        $schedule->call([\App\Http\Controllers\GameGroupController::class, 'generate'])
            ->twiceDaily(1, 13)
            ->timezone('Europe/London')
            ->name('generate_game_groups')
            ->onOneServer();

        // Monthly cleanup
        $schedule->call(function () {
            \App\Models\GameGroup::whereMonth(
                'generated_date',
                '!=',
                now('Europe/London')->month
            )->delete();
        })->monthlyOn(1, '03:00')
          ->timezone('Europe/London')
          ->name('monthly_game_groups_cleanup')
          ->onOneServer();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}

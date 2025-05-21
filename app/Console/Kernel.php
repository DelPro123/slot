<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\PredictColorGame;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        PredictColorGame::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Production schedule (UK time)
        $schedule->command('games:predict-color')
            ->timezone('Europe/London')
            ->dailyAt('1:00'); // 1PM UK

        $schedule->command('games:predict-color')
            ->timezone('Europe/London')
            ->dailyAt('16:00'); // 4PM UK

        $schedule->command('games:predict-color')
            ->timezone('Europe/London')
            ->dailyAt('20:00'); // 8PM UK

        // // Hidden test schedule: runs every minute only in local/dev environments
        // if (app()->environment(['local', 'development', 'testing'])) {
        //     $schedule->command('games:predict-color')
        //         ->timezone('Europe/London')
        //         ->everyMinute(); // Test frequency
        // }
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}

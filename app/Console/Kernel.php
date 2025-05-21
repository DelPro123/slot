<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\PredictColorGame;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        PredictColorGame::class,  // Register the command here
    ];

    protected function schedule(Schedule $schedule)
    {
        // Schedule the command to run every minute for testing purposes
        // Change it to twiceDaily(6, 18) for the actual schedule (6AM and 6PM)
        $schedule->command('games:predict-color')
            ->timezone('Europe/London')
            ->everyMinute();  // Change this to twiceDaily(6, 18) for 6AM & 6PM

        // Alternatively, you can schedule it for specific time slots as needed
        // $schedule->command('games:predict-color')->twiceDaily(6, 18); // 6AM & 6PM UK time
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}

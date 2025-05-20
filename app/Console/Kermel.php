<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\PredictColorGame::class,
    ];

    protected function schedule(Schedule $schedule)
    {
      $schedule->command('games:predict-color')
        ->timezone('Europe/London')
        ->twiceDaily(6, 18); // 6 AM and 6 PM UK time
        // ->everyMinute();
    }
}

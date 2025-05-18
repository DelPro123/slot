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
      $schedule->command('games:predict-color')->dailyAt('01:00')->timezone('Europe/London');
      $schedule->command('games:predict-color')->dailyAt('13:00')->timezone('Europe/London'); // 1PM
    }
}

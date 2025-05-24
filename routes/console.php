<?php

use Illuminate\Support\Facades\Schedule;

// Main schedule in UK time
 Schedule::command('games:predict-color')
    ->timezone('Europe/London')
    ->dailyAt('01:00'); // 1AM UK

 Schedule::command('games:predict-color')
    ->timezone('Europe/London')
    ->dailyAt('16:00'); // 4PM UK

 Schedule::command('games:predict-color')
     ->timezone('Europe/London')
    ->dailyAt('20:00'); // 8PM UK

// //Optional: for development/testing, run every minute
// if (app()->environment(['local', 'development', 'testing'])) {
//     Schedule::command('games:predict-color')
//         ->timezone('Europe/London')
//         ->everyMinute();
// }


<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

//Artisan::command('newsletter:process-scheduled', function () {
//    $this->info('Processing scheduled newsletters...');
//})->purpose('Process scheduled newsletters')->everyMinute();


Schedule::Command('newsletter:process-scheduled')->everyFiveMinutes();
Schedule::Command('manual-email:process-scheduled')->everyFiveMinutes();
Schedule::Command('continue-order:send-reminders')->dailyAt('08:00');
Schedule::Command('emails:send-birthday')->dailyAt('08:00');
Schedule::Command('abandoned-cart:send-reminders')->dailyAt('08:00');

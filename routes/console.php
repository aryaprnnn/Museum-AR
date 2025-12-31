<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule booking reminders
Schedule::command('bookings:send-reminders --days=1')
    ->dailyAt('09:00')
    ->timezone('Asia/Jakarta')
    ->description('Send booking reminders 1 day before event');

Schedule::command('bookings:send-reminders --days=3')
    ->dailyAt('10:00')
    ->timezone('Asia/Jakarta')
    ->description('Send booking reminders 3 days before event');

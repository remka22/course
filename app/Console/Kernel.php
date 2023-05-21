<?php

namespace App\Console;

use App\Http\Controllers\ServiceScheduleController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            ServiceScheduleController::setMonth();
        })->daily();

        $schedule->call(function () {
            // код, выполняемый раз в минуту
        })->everyMinute();

        $schedule->call(function () {
            // код, выполняемый раз в 5 минут
        })->everyFiveMinutes();

        $schedule->call(function () {
            // код, выполняемый раз в 10 минут
        })->everyTenMinutes();

        $schedule->call(function () {
            // код, выполняемый каждый час
        })->hourly();

        $schedule->call(function () {
            // код, выполняемый каждый день в 08:00
        })->dailyAt('08:00');

        $schedule->call(function () {
            // код, выполняемый два раза в день в 01:00 и в 12:00
        })->twiceDaily(1, 12);

        $schedule->call(function () {
            // код, выполняемый раз в неделю
        })->weekly();

        $schedule->call(function () {
            // код, выполняемый каждый понедельник в 12:00
        })->weekly()->mondays()->at('12:00');

        $schedule->call(function () {
            // код, выполняемый раз в месяц
        })->monthly();

        $schedule->call(function () {
            // код, выполняемый 15 числа каждого месяца в 12:00
        })->monthlyOn(15, '12:00');

        $schedule->call(function () {
            // код, выполняемый раз в три месяца (раз в квартал)
        })->quarterly();

        $schedule->call(function () {
            // код, выполняемый раз в год
        })->yearly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

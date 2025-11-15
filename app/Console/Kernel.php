<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Register custom Artisan commands
     */
    protected $commands = [
        \App\Console\Commands\KirimReminderEmail::class, // <- Tambah baris ini
        \App\Console\Commands\ReminderHelpdesk::class,
        \App\Console\Commands\ReminderTicketLoan::class
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Menjalankan command reminder setiap hari jam 07:00
        $schedule->command('reminder:kirim')->dailyAt('09:30');
        $schedule->command('helpdesk:sent')->dailyAt('08:00');
        $schedule->command('reminder:loan')->dailyAt('08:00');
        // Jika ingin testing bisa diganti sementara:
        // $schedule->command('reminder:kirim')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

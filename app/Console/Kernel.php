<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\ETLProcess::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // ETL incremental cada hora (solo datos nuevos)
        $schedule->command('etl:run')
                 ->hourly()
                 ->appendOutputTo(storage_path('logs/etl.log'));
        
        // ETL completo cada domingo a medianoche
        $schedule->command('etl:run --full')
                 ->weeklyOn(0, '0:00')
                 ->appendOutputTo(storage_path('logs/etl_full.log'));
        
        // Limpiar logs antiguos
        $schedule->command('log:clean --days=7')->daily();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
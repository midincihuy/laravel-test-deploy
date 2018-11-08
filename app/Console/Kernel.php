<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Scheduler;
use Schema;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('sync:email')
        // ->dailyAt('04:00');

        // $schedule->command('customer:request')
        // ->dailyAt('05:00');

        // $schedule->command('check:tunnel')
        // ->everyMinute();

        // if(Schema::hasTable('schedulers')){
        //     $scheduler = Scheduler::all();

        //     foreach ($scheduler as $sch) {
        //         $schedule->command($sch->command)->cron($sch->cron_expression);
        //     }
        // }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

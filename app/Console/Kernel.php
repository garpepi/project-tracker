<?php

namespace App\Console;

use App\Models\Email_configuration;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\sendMailEveryDay::class,
        Commands\sendMailEveryWeek::class,
        Commands\sendMailEveryMonth::class,
        Commands\sendMailToCreateInvoice::class,
        Commands\sendMailPayment::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        // $schedule->command('sendmail:day')
        //     ->everyTwoMinutes();
        // $schedule->command('sendmail:createInvoices')
        //     ->dailyAt("22:23")->withoutOverlapping();

        // $schedule->command('sendmail:payment')
        //     ->dailyAt("14:45")->withoutOverlapping();


        $day = Email_configuration::select('duration')->where('id', 5)->first();
        $week = Email_configuration::select('duration')->where('id', 8)->first();
        $month = Email_configuration::select('duration')->where('id', 7)->first();

        $h = (string)$day->duration;
        $w = $week->duration;
        $m = $month->duration;

        $schedule->command('sendmail:day')
            ->dailyAt("{$h}:00")->withoutOverlapping();
                // ->dailyAt("20:03")->withoutOverlapping();
        $schedule->command('sendmail:week')
            ->weeklyOn($w, '8:00')->withoutOverlapping();
        $schedule->command('sendmail:month')
            ->monthlyOn($m, '8:00')->withoutOverlapping();

            //ketika data invoice == true
            // $schedule->command('emails:send')->daily()->when(function () {
            //     return true;
            // });
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

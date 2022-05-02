<?php

use App\Console\Commands\sendMailEveryDay;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Artisan::command('sendmail:day',[sendMailEveryDay::class]);

Artisan::command('sendmail:run',function(){
    // Artisan::call('sendmail:day');
    // Artisan::call('sendmail:week');
    // Artisan::call('sendmail:month');
    Artisan::queue('sendmail:payment');
    Artisan::queue('sendmail:createInvoices');
    Artisan::queue('sendmail:day');
    Artisan::queue('sendmail:week');
    Artisan::queue('sendmail:month');
})->describe('Running commands');

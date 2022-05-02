<?php

namespace App\Console\Commands;

use App\Models\Email;
use App\Mail\SendMail;
use App\Models\Progress_item;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class sendMailToCreateInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendmail:createInvoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send mail notification to create an invoice';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $nonInvoice = Progress_item::whereNotNull('status_id')->whereNull('invoice_status_id')->get();
        if ($nonInvoice == true) {
            foreach($nonInvoice as $notif){
            $details = [
                'title' => $notif->name_progress,
                'body' => ['Your progress is running, click the payment button to complete your payment']
            ];

             //day
             $listMail = Email::where('email_config_id', 5)->get();
             if ($listMail == true) {
                 foreach ($listMail as $l) {
                     Mail::to($l->email)->send(new SendMail($details));
                     }
                         }else{
                             return 0;
                     }
            // Mail::to("projecttrac6@gmail.com")->send(new SendMail($details));
            // Mail::from('projecttrac6@gmail.com', 'Project-Tracking');
            // Mail::to("aldi24511@gmail.com")->send(new SendMail($details));
            }
        }else{
            return 0;
        }
    }
}

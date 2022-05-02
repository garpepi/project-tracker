<?php

namespace App\Console\Commands;

use App\Mail\SendMail;
use App\Models\Email;
use App\Models\Invoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class sendMailPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendmail:payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send mail notification to payment';

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
        $invoiceList = Invoice::with(
            'project',
            'project.contract.client',
            'progress_item')
            ->withCount(['actual_payment as actualPay' =>
            function($query)
            {
                $query->select(DB::raw('SUM(amount)'));
            }])->get();

            if ($invoiceList == true) {
                foreach($invoiceList as $notif){
                    // $pay = $notif->amount_total - $notif->actualPay;
                    if ($notif->amount_total - $notif->actualPay > 0) {
                        $pay =  $notif->amount_total - $notif->actualPay;
                    $details = [
                        'title' => $notif->progress_item->name_progress,
                        'body' => ["Please complete the payment. <br>
                                    Detail Info <br>
                                    Project Name           : {$notif->project->name} <br>
                                    Incoming Invoices      : {$notif->created_at} <br>
                                    Amount neet to be paid : Rp. {$pay} <br>
                                "]
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
                    }else{
                        return 0;
                    }
                }
            }else{
                return 0;
            }
    }
}

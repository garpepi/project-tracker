<?php

namespace App\Console\Commands;

use App\Mail\SendMailCreateInvoice;
use App\Mail\SendMailPayment;
use App\Models\Email;
use App\Models\Invoice;
use App\Models\Progress_item;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class sendMailEveryWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendmail:week';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a weekly email to all users';

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
                        $data[] = "<td>{$notif->project->name}</td>
                                    <td>{$notif->progress_item->name_progress}</td>
                                    <td>{$notif->created_at}</td>
                                    <td>{$pay}</td>
                                    ";
                    //    array_push($data, "<td>{$notif->progress_item->name_progress}<td>");
                    }
                  }
                // $data = $dataSet;
                  $details = [
                    'title' => 'Please complete the payment :',
                    'body' => $data,
                    ];
                  //day
                  $listMail = Email::where('email_config_id', 8)->get();
                  if ($listMail == true) {
                      foreach ($listMail as $l) {
                          Mail::to($l->email)->send(new SendMailPayment($details));
                          }
                              }else{
                                  return 0;
                              }
            }else{
                return 0;
            }

        //Create Invoices

        $nonInvoice = Progress_item::whereNotNull('status_id')->whereNull('invoice_status_id')->get();
        if ($nonInvoice == true) {
            foreach($nonInvoice as $notif){
                $datanonI[] = "<td>{$notif->name_progress}</td>
                                <td>{$notif->payment_percentage}%</td>
                                <td>Running</td>";
            }

            $details = [
                'title' => 'Your progress is running, click the payment button to complete your payment',
                'body' => $datanonI,
            ];
             //day
             $listMail2 = Email::where('email_config_id', 8)->get();
             if ($listMail2 == true) {
                 foreach ($listMail2 as $l) {
                     Mail::to($l->email)->send(new SendMailCreateInvoice($details));
                     }
                         }else{
                             return 0;
                     }
            // Mail::to("projecttrac6@gmail.com")->send(new SendMail($details));
            // Mail::from('projecttrac6@gmail.com', 'Project-Tracking');
            // Mail::to("aldi24511@gmail.com")->send(new SendMail($details));

        }else{
            return 0;
        }
        // $value = 'message from project-tracking';

        // $listMail = Email::where('email_config_id', 8)->get();
        // if ($listMail == true) {
        //     foreach ($listMail as $l) {
        //         Mail::raw("{$value}", function ($mail) use ($l) {
        //             $mail->from('projecttrac6@gmail.com', 'Project-Tracking');
        //             $mail->to($l->email)->subject('send messages every week');
        //         });
        //         }
        //         $this->info('sent to All Users');
        // }else{
        // return 0;
        // }
    }
}

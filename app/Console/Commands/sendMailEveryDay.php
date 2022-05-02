<?php

namespace App\Console\Commands;

use App\Mail\SendMail;
use App\Mail\SendMailCreateInvoice;
use App\Mail\SendMailPayment;
use App\Models\Email;
use App\Models\Invoice;
use App\Models\Progress_item;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class sendMailEveryDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendmail:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a Daily email to all users';

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
            'project.contract',
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
                        //menghitung tunggakan dan merubah format
                        $pay =  $notif->amount_total - $notif->actualPay;
                        $hasil_rupiah = "Rp " . number_format($pay,2,',','.');
                        $hasil_rupiahlast = "Rp " . number_format($notif->actualPay,2,',','.');
                        //merubah format hari
                        $dateCreate = date_format($notif->created_at,"D, d M Y H:i:s");

                        $data[] = "<td>{$notif->project->name}</td>
                                    <td>{$notif->project->no_po}</td>
                                    <td>{$notif->progress_item->name_progress}</td>
                                    <td>{$dateCreate}</td>
                                    <td>{$hasil_rupiahlast}</td>
                                    <td>{$hasil_rupiah}</td>
                                    ";
                                    break;
                    //    array_push($data, "<td>{$notif->progress_item->name_progress}<td>");
                    }
                  }
                // $data = $dataSet;
                  $details = [
                    'title' => 'Please complete the payment :',
                    'body' => $data,
                    ];
                  //day
                  $listMail = Email::where('email_config_id', 5)->get();
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

        $nonInvoice = Progress_item::whereNotNull('status_id')
        ->whereNull('invoice_status_id')
        ->with('project',
        'project.contract')->get();
        if ($nonInvoice == true) {
            foreach($nonInvoice as $notif){
                //yang harus dibayarkan
                $paid = ($notif->payment_percentage / 100) * $notif->project->price;
                $paidrp = "Rp " . number_format($paid,2,',','.');
                $datanonI[] = "<td>{$notif->name_progress}</td>
                                <td>{$notif->project->contract->name}</td>
                                <td>{$notif->project->no_po}</td>
                                <td>{$notif->payment_percentage}%</td>
                                <td>{$paidrp}</td>
                                ";

            }
            $details = [
                'title' => 'Your progress is running, click the payment button to complete your payment',
                'body' => $datanonI,
            ];
             //day
             $listMail2 = Email::where('email_config_id', 5)->get();
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
    }
}

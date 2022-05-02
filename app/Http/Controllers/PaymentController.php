<?php

namespace App\Http\Controllers;

use App\Models\Actual_payment;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Progress_item;
use App\Models\Proof_of_invoice_payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{
    public function index()
    {
       // $nonInvoice = Progress_item::whereNotNull('status_id')->whereNull('invoice_status_id')->get();
       // dd($nonInvoice);
         $clients= Client::all();
         $invoiceList = Invoice::with(
             'project',
             'tax_proof.tax',
             'project.contract.client',
             'progress_item')
             ->withCount(['actual_payment as actualPay' =>
             function($query)
             {
                 $query->select(DB::raw('SUM(amount)'));
             }])->orderBy('id', 'desc')->get();
            //  dd($invoiceList);
         return view('payments.v_index', compact('invoiceList','clients'));
    }
    public function show(Request $request)
    {
        // $id = $request->id;
        $getAcc = Actual_payment::with('invoice.project',
                                        'invoice.progress_item',
                                        'invoice.project.contract.client')
                                        ->where('invoice_id', $request->id)->get();
        return response()->json(['dataPay' => $getAcc]);
        // return response()->json(['msg'=>'Updated Successfully',
        // 'dataid' => $id,
        // 'success'=>true]);
        // return datatables()->of($users)
        //       ->make(true);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $harga_str = preg_replace("/[^0-9]/", "" , $request->amount);
        $amountNeedToBePaid = preg_replace("/[^0-9]/", "" , $request->amountNeedToBePaid);
        $harga_int = (int)$harga_str;
        $amountNeedToBePaidInt = (int)$amountNeedToBePaid;
        $userid = session()->get('token')['user']['id'];
        $request->merge([
            'amount' => $harga_int,
            'amountNeedToBePaid' => $amountNeedToBePaidInt,
            'user_confirm' => $userid,
        ]);
          $request->validate([
          'amount' => 'required|lte:amountNeedToBePaid',
          'payment_date' => 'required|date|before_or_equal:today',
          'filename' => 'required'
         ]);
         $files = $request->file('filename');
        if ($request->close == "on") {
            $request->merge([
                'close' => 1,
            ]);
            $request->validate([
                'amount' => 'required|lte:amountNeedToBePaid',
                'payment_date' => 'required|date|before_or_equal:today',
                'filename' => 'required',
                'desc' => 'required'
               ]);
            Invoice::where('id', $request->invoice_id)->update([
                'close' => 1,
                'description' => $request->desc
            ]);
        }
        if ($harga_int == $amountNeedToBePaidInt) {
            $request->merge([
                'close' => 1,
            ]);
            Invoice::where('id', $request->invoice_id)->update([
                'close' => 1
            ]);
        }
         if($files != null){
                $id = Actual_payment::create($request->all())->id;
                 $filename = time().'.'.$files->getClientOriginalName();
                 Proof_of_invoice_payment::create([
                 'actual_payment_id' => $id,
                 'user_upload' => $userid,
                 'filename' => $filename,
                 ]);
                 $files->move(public_path('proof_of_invoice_payment'), $filename);
                //  dd($cek);

         }else {
          Alert::toast('No files uploaded !!!', 'error');
         return back()->with('status', 'No files uploaded');
         }
         Alert::toast('Data Berhasil Ditambahkan !!!', 'success');
        return redirect('/payments');
    }
}

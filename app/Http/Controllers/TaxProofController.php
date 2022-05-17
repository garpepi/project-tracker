<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Progress_item;
use App\Models\Tax_proof;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaxProofController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taxproof = Tax_proof::with('project','progress_item','tax')
        ->whereNotNull('invoice_id')->where('received',0)
        ->whereHas('invoice', function($q){
            $q->where('close', null);
         })->groupby('invoice_id')->orderBy('id', 'desc')->get();
        // dd($taxproof);
        $taxproofwithtaxcollect = Tax_proof::with('project','progress_item','tax')
        ->whereNotNull('invoice_id')->where('received',0)
        ->whereHas('invoice', function($q){
            $q->where('close', null);
         })->get();
        //  dd($taxproofwithtaxcollect);
        return view('tax.index', compact('taxproof','taxproofwithtaxcollect'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Tax_proof $tax_proof,$id)
    {
        // dd($request->all());
        if ($request->urlname == 'invoice_status') {
            $taxprooflist = Tax_proof::with('tax')->where('progress_id',$request->id)->get();
            $input = array();

            foreach ($taxprooflist as $key => $value) {
                // if ($value->tax->name == 'PPN') {
                //     $input[] = "<div class='form-group row'>
                //                         <label class='col-sm-3 col-form-label'>{$value->tax->name}</label>
                //                         <div class='input-group mb-3 col-sm-9'>
                //                             <input type='hidden' name='idtaxproof[]' value='{$value->id}' class='form-control'>
                //                             <input type='number' readonly name='percentage[]' class='form-control' value='10' style='text-align:right;'>
                //                             <div class='input-group-append'>
                //                             <span class='input-group-text'><strong>%</strong></span>
                //                             </div>
                //                         </div>
                //                     </div>";
                // }else{
                    $input[] = "<div class='form-group row'>
                                            <label class='col-sm-3 col-form-label'>{$value->tax->name}</label>
                                            <div class='input-group mb-3 col-sm-9'>
                                                <input type='hidden' name='idtaxproof[]' value='{$value->id}' class='form-control'>
                                                <input required type='number' name='percentage[]' class='form-control' step='0.01' style='text-align:right;'>
                                                <div class='input-group-append'>
                                                <span class='input-group-text'><strong>%</strong></span>
                                                </div>
                                            </div>
                                        </div>";
                // }
            }
            // dd($taxprooflist[0]->tax->name);
            return response()->json([
                'data' => 1,
                'input' => $input
            ]);
        }

        if ($tax_proof == true) {
            $getproject = $tax_proof->with('project.contract','invoice')->where('id',$id)->first();
            $taxdetail = Tax_proof::with('project','invoice','progress_item','tax')
            ->where('invoice_id',$getproject->invoice_id)
            ->whereHas('progress_item', function($q){
                $q->where('invoice_status_id', 2);
             })->get();
             $actualPay = Invoice::with(
                'project',
                'tax_proof.tax',
                'project.contract.client',
                'progress_item')
                ->withCount(['actual_payment as actualPay' =>
                function($query)
                {
                    $query->select(DB::raw('SUM(amount)'));
                }])->where('id',$getproject->invoice_id)->first();

            //  $sumtax = $tax_proof->where('id',$id)->sum('percentage');
            // dd($invoiceList);
            return view('tax.v_show', compact('taxdetail','getproject','actualPay'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $idcek = $id;
        // $urlcek = $urlname;
        dd($id);
       return response()->json([
           'info' => 10,
       ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function applytax($id)
    {
        // $masuk = 'acc';
        $taxreceived = Tax_proof::where('id',$id)->update([
            'received' => 1
        ]);
        if ($taxreceived) {
            return response()->json([
                'received' => 'acc'
            ]);
        }else {
            return response()->json([
                'received' => 'no'
            ]);
        }

    }
}

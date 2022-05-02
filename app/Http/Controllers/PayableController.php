<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Actual_payable_payed;
use App\Models\Project_cost;
use App\Models\Proof_of_payable_paid;
use App\Models\Tax;
use App\Models\Tax_project_cost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PayableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projectcost = Project_cost::with('progress_item','suplier')
        ->withCount(['progress_item as countBOQ' => function($q){
            $q->select(DB::raw('SUM(budget_of_quantity)'));
        }])->withCount(['progress_item as countUse' => function($q){
            $q->select(DB::raw('Count(progress_item_id)'));
        }])->groupby('progress_item_id')->where('payed',0)->orderBy('id', 'desc')->get();
        // $projectcost = Project_cost::with('progress_item','suplier')->groupby('progress_item_id')->get();
        $projectcostwithProjectItem = Project_cost::with('progress_item','suplier')->get();
        // dd($projectcost);
        return view('payable.v_index',compact('projectcost','projectcostwithProjectItem'));
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
        //change RP to Int
        $amount = $this->changeRPtoInt($request->amount);
        $BOQ = $this->changeRPtoInt($request->BOQ);
        $amountNeedToBePaid = $this->changeRPtoInt($request->amountNeedToBePaid);
        $paid = $this->changeRPtoInt($request->paid);
        $dpp = $this->changeRPtoInt($request->dpp);

        $request->merge([
            'amount' => $amount,
            'amountNeedToBePaid' => $amountNeedToBePaid,
            'BOQ' => $BOQ,
            'dpp' => $dpp,
            'paid' => $paid,
        ]);
        // $amountNeedToBePaid = preg_replace("/[^0-9]/", "" , $request->BOQ);
        // $amountNeedToBePaidInt = (int)$amountNeedToBePaid;
        $userid = session()->get('token')['user']['id'];
        $request->merge([
            'create_by' => $userid,
        ]);

        if ($request->amountNeedToBePaid != null) {
            $validator = Validator::make($request->all(), [
                'amount' => 'required|lte:amountNeedToBePaid',
                'payment_date' => 'required|date|before_or_equal:today',
                'filename' => 'required'
                ]);
                if ($validator->fails()) {
                // dd($validator);
                return back()
                        ->with('errorPayment', 'Please try again')->withInput()->withErrors($validator);
                }
        }else{
            $validator = Validator::make($request->all(), [
                'amount' => 'required|lte:BOQ',
                'payment_date' => 'required|date|before_or_equal:today',
                'filename' => 'required'
                ]);
                if ($validator->fails()) {
                // dd($validator);
                return back()
                        ->with('errorPayment', 'Please try again')->withInput()->withErrors($validator);
                }
        }

        $files = $request->file('filename');
        if($files != null){
            $actualpayablepayed = Actual_payable_payed::create([
                'project_cost_id' => $request->project_cost_id,
                'project_id' => $request->project_id,
                'amount' => $amount,
                'create_by' => $request->create_by,
                'payment_date' => $request->payment_date
            ]);

            if (!empty($request->tax)) {
                foreach ($request->tax as $key => $t) {
                    $getTaxProjectCost = Tax_project_cost::where('project_cost_id',$request->project_cost_id)
                    ->where('tax_id',$t)->first();
                    if (empty($getTaxProjectCost)) {
                        Tax_project_cost::create([
                            'project_cost_id' => $request->project_cost_id,
                            'project_id' => $request->project_id,
                            'tax_id' => $t,
                            'percentage' => $request->percentage[$key],
                            'create_by' => $request->create_by,
                        ]);
                    }
                }
            }


             $filename = time().'.'.$files->getClientOriginalName();
             Proof_of_payable_paid::create([
             'actual_payable_payed_id' => $actualpayablepayed->id,
             'user_upload' => $userid,
             'filename' => $filename,
             ]);
             $files->move(public_path('proof_of_payable_payment'), $filename);
            //  dd($cek);

            if ($request->amountNeedToBePaid != null) {
                if ($amount >= $amountNeedToBePaid) {
                    Project_cost::where('id',$request->project_cost_id)->update([
                        'payed' => 1,
                    ]);
                }
            }else{
                if ($amount >= $BOQ) {
                    Project_cost::where('id',$request->project_cost_id)->update([
                        'payed' => 1,
                    ]);
                }
            }

            return back()->with('successPayment', 'Payment Completed');
     }else {
      Alert::toast('No files uploaded !!!', 'error');
     return back()->with('status', 'No files uploaded');
     }
        // dd($actualpayablepayed->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
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

    public function pay($id)
    {
        $projectcost = Project_cost::with('suplier','progress_item')->withCount(['actual_payable_payed as payablePaid' =>
        function($query)
        {
            $query->select(DB::raw('SUM(amount)'));
        }])->where('progress_item_id',$id)->where('payed',0)->orderBy('id', 'desc')->get();
        // dd($projectcost);
        $progress = Project_cost::with('progress_item')->where('progress_item_id',$id)->orderBy('id', 'desc')->first();
        $taxs = Tax::all();
        return view('payable.v_list_payable_progress',compact('projectcost','progress','taxs'));
    }

    public function changeRPtoInt($value)
     {
        $harga_str = preg_replace("/[^0-9]/", "" , $value);
        $harga_int = (int)$harga_str;
        return $harga_int;
     }
}

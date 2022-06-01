<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Contract;
use App\Models\Clients;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\Progress_doc;
use App\Models\Progress_item;
use App\Models\Project_cost;
use App\Models\Project_cost_history;
use App\Models\Progress_status;
use App\Models\Suplier;
use App\Models\Tax_proof;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OperationalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $operationals = Project::with(['contract.client'])->orderBy('id', 'desc')->get();
        return view('operational-cost.index', compact('operationals'));
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $progress_items= Progress_item::where('project_id', $id)->get();
        $progress_docs = Progress_item::with('doc')->where('project_id', $id)->get();
        $project_cost = Project_cost::where('project_id', $id)->get();
        return view('operational-cost.show', compact('progress_docs', 'id', 'progress_items','project_cost'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Progress_item  $progress_item
     * @return \Illuminate\Http\Response
     */
    public function edit(Progress_item $progress_item, $id)
    {
        $progress_items= Progress_item::where('project_id', $id)->get();
        $progress_docs = Progress_item::with('doc')->where('project_id', $id)->get();
        $project_cost = Project_cost::where('project_id', $id)->get();
        $po_num = Project::where('id', $id)->first();
        $taxproofs = Tax_proof::with('tax')->get();
        $suppliers = Suplier::all();
        return view('operational-cost.edit', compact('progress_docs', 'id','progress_items','project_cost','po_num','taxproofs','suppliers'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Project_cost $project_cost)
    {


        //getOldData
        $CostingOld = Project_cost::where('project_id',$id)->get();

        if($request->filled($request->suplier)){
        }else {
            if (!empty($request->BOQ)) {
                $BOQ1 = [];
                foreach($request->BOQ as $key => $v){
                    if ($v != null) {
                            $h_boq = preg_replace("/[^0-9]/", "" , $v);
                            $h_intboq = (int)$h_boq;
                            array_push($BOQ1, $h_intboq);
                    }else{
                        array_push($BOQ1, null);
                    }
                }
                if (!empty($BOQ1)) {
                    $request->merge([
                        'BOQ1' => $BOQ1
                    ]);
                     }
                }
                $validator = Validator::make($request->all(), [
                'suplier.*' => 'required',
                'BOQ1.*' => 'required|integer|gt:0',
                'progress.*' => 'required',
                ]);
                if ($validator->fails()) {
                return back()
                        ->with('errorUpload', 'Please try again')->withInput()->withErrors($validator);
                }
                // dd($request->all());
            foreach ($request->suplier as $key=>$project_cost) {
                if($request->filled($project_cost)){
                }else {
                    if(!empty($request->cost_id[$key])){
                        Project_cost::where('id', $request->cost_id[$key])->update([
                        'suplier_id' => $project_cost,
                        'progress_item_id' => $request->progress[$key],
                        'desc' => $request->desc[$key],
                        'budget_of_quantity' => $request->BOQ1[$key],
                        ]);
                    }
                    if (empty($request->cost_id[$key]) && $project_cost != null) {
                        Project_cost::create([
                        'project_id' => $id,
                        'progress_item_id' => $request->progress[$key],
                        'suplier_id' => $project_cost,
                        'desc' => $request->desc[$key],
                        'budget_of_quantity' => $request->BOQ1[$key],
                        ]);
                    }
                }
            }

            foreach ($CostingOld as $key => $value) {
                Project_cost_history::create([
                    'changes_date' => Carbon::now(),
                    'project_cost_id' => $value->id,
                    'progress_item_id' => $value->progress_item_id,
                    'suplier_id' => $value->suplier_id,
                    'project_id' => $value->project_id,
                    'desc' => $value->desc,
                    'budget_of_quantity' => $value->budget_of_quantity,
                ]);
            }
        }

        return back()->with('status', 'Update Success!');
        // return redirect('/operationals')->with('status', 'Update Success!');
    }

    public function uploadProgress(Request $request)
    {
        $validator = Validator::make($request->all(), [
        // 'filename.*' => 'required|mimes:pdf,xlx,csv,doc,docx',
        'filename.*' => 'required',
        ]);
          if ($validator->fails()) {
                     return back()
                            ->with('errorUpload', 'The file upload must be a file of type: pdf, xlx, csv, doc, docx.')
                            ->withInput();
              }
        $files = $request->file('filename');
        if($files){
            foreach ($files as $file) {
                $filename = time().'.'.$file->getClientOriginalName();
                Progress_doc::create([
                'filename' => $filename,
                'progress_item_id' => $request->progress_id,
                ]);
                $file->move(public_path('progress_docs'), $filename);
            }
        }else {
        return back()->with('null', 'No files uploaded');
        }
        return back()->with('status', 'Upload Success');
    }
     public function changeStatus(Request $request)
    {
		$sumAmount = "";
        if ($request->name == "invoice_status")
            {
                if ($request->urlname = "invoice-taxproof") {
                    // $validator = Validator::make($request->all(), [
                    //     'invoice_number' => 'required',
                    //     'percentage.*' => 'required|gt:0',
                    //     ]);
                    //     if ($validator->fails()) {
                    //         return response()->json([
                    //             'success'=>'upss error',
                    //             'errors' => $validator,
                    //         ]);
                    //       }
                        // dd($request->all());
                    $userid = session()->get('token')['user']['id'];
                    $getProgress = Progress_item::where('id', $request->id)->first();
                    $getAmout = Project::where('id', $getProgress->project_id)->first();
                    $sumAmount = ($getProgress->payment_percentage / 100) * $getAmout->total_price ;
                    $getstatus = Progress_status::where('status', $request->dataOn)->first();
                    $status_id = $getstatus->id;
                    Progress_item::where('id', $request->id)->update([
                    'invoice_status_id' => $status_id,
                    ]);
                    $createInvoice = Invoice::create([
                        'invoice_number' => $request->invoice_number,
                        'project_id' => $getProgress->project_id,
                        'progress_item_id' => $request->id,
                        'user_trigger' => $userid,
                        'amount_total' => $sumAmount,
                    ]);
                    if (!empty($request->idtaxproof)) {
                        foreach ($request->idtaxproof as $key => $idtax) {
                            Tax_proof::where('id',$idtax)->update([
                                'percentage' => $request->percentage[$key],
                                'invoice_id' => $createInvoice->id,
                            ]);
                        }
                    }
                }

        } elseif
        ($request->name == "status"){
            $getstatus = Progress_status::where('status', $request->dataOn)->first();
            $status_id = $getstatus->id;
            Progress_item::where('id', $request->id)->update([
            'status_id' => $status_id,
            ]);
        }
        // $status_id = $request->name;
        return response()->json(['success'=>'User status change successfully.'.$sumAmount]);
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
     public function destroyDoc(Progress_doc $progress_doc)
    {
        $file = Progress_doc::find($progress_doc->id);
        $filename = $progress_doc->filename;
        if(File::exists(public_path('progress_docs/'.$filename))){
           File::delete(public_path('progress_docs/'.$filename));
        }
        Progress_doc::destroy($progress_doc->id);
        return response()->json(['success'=>'Delete successfully.'.$filename]);
    }
}

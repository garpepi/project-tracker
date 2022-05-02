<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Contract;
use App\Models\Client;
use App\Models\Contract_history;
use App\Models\Contract_doc;
use App\Models\Type;
use App\Models\Project;
use App\Models\Progress_item;
use App\Models\Project_cost;
use App\Models\Project_history;
use App\Models\Progress_item_history;
use Carbon\Carbon;
use File;
use Validator;
use Illuminate\Support\Facades\DB;
class ContractprojectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roleView = session()->get('token')['user'];
        if ($roleView['role'] == "User") {
            $contracts= Contract::with('client','viewable')->whereHas('viewable', function($q)
                        {
                            $roleViewID = session()->get('token')['user']['id'];
                            $q->where('user_id', $roleViewID)->orWhere('user_id', null);
                        })->orderBy('id', 'desc')->get();
        }else{
            $contracts= Contract::with('client')->orderBy('id', 'desc')->get();
        }
		$projects= Project::with('contract','contract.type')->orderBy('id', 'desc')->get();
        return view('contractspo.v_index', compact('contracts','projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients= Client::all();
        $types= Type::all();
        $typecek = Contract::with('type')->first();
        return view('contractspo.v_create_contract', compact('clients','types','typecek'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        // 'name' => 'required',
        // 'client_id' => 'required',
        // 'cont_num' => 'required|integer|min:1',
        // 'type_id' => 'required'
        // ]);
        // $validator = Validator::make($request->all(), [
        // 'filename.*' => 'required|mimes:pdf,xlx,csv,doc,docx',
        // ]);
        // if ($validator->fails()) {
        //              return back()
        //                     ->with('errorUpload', 'The file upload must be a file of type: pdf, xlx, csv, doc, docx.')
        //                     ->withInput();
        // }
        // $types= Type::where('id', $request->type_id)->first();
        // if($types->required != 0){
        //     $request->validate([
        //         'volume' => 'required',
        //         'unit' => 'required',
        //         ]);
        // }

        // $userid = session()->get('token')['user']['id'];
        // $request->merge([
        //  'created_by' => $userid,
        // ]);
        // $contract = Contract::create($request->all());
        // $files = $request->file('filename');
        // if($files){
        //     foreach ($files as $file) {
        //         $filename = time().'.'.$file->getClientOriginalName();
        //         Contract_doc::create([
        //         'filename' => $filename,
        //         'contract_id' => $contract->id,
        //         ]);
        //         $file->move(public_path('docs'), $filename);
        //     }
        // }
        // return redirect('/contracts')->with('status', 'Success add Contract!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract, Project $project)
    {
        // $filename =$contract->doc;
        // $clients= Client::all();

		// $projects= Project::with('progress_item', 'project_cost')->get();
		// dd($projects);
        // $project_cost =$project->project_cost;
        // $progress_item =$project->progress_item;
		// $projContract = Project::with('Contract')->get();
        // return view('contractspo.v_show', compact('contract', 'clients', 'filename', 'project', 'contracts', 'progress_item', 'project_cost', 'projContract', 'types'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract)
    {
        $filename =$contract->doc;
        $clients= Client::all();
        $typecek = Contract::with('type')->first();
        $types= Type::all();
        return view('contractspo.v_edit', compact('contract', 'clients', 'filename','types','typecek'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contract $contract)
    {
        $validator = Validator::make($request->all(), [
        'filename.*' => 'required|mimes:pdf,xlx,csv,doc,docx',
        ]);
        if ($validator->fails()) {
            return back()
                    ->with('errorUpload', 'The file upload must be a file of type: pdf, xlx, csv, doc, docx.')
                    ->withInput();
        }
        $newType_id = $request->get('type_id');
        $dataOlds =Contract::all();
        foreach($dataOlds as $dataold){
            if($dataold->id==$contract->id){
                $name= $dataold->name;
                $client_id= $dataold->client_id;
                $cont_num= $dataold->cont_num;
                $sign_date= $dataold->sign_date;
                $volume= $dataold->volume;
                $unit = $dataold->unit;
                $price = $dataold->price;
                $start_date = $dataold->start_date;
                $end_date = $dataold->end_date;
                $type_id = $dataold->type_id;
                $created_by = $dataold->created_by;
            }
        }
        if($newType_id != $type_id){
            Contract::where('id', $contract->id)
            ->update([
                'type_id' => $newType_id,
                ]);
        }
        if($name != null ){
            Contract::where('id', $contract->id)
            ->update([
            'name' => $name,
            ]);

        }else{
            Contract::where('id', $contract->id)
            ->update(['name' => $request->name]);
        }
        if($client_id != null ){
            Contract::where('id', $contract->id)
            ->update([
            'client_id' => $client_id,
            ]);

        }else{
            Contract::where('id', $contract->id)
            ->update(['client_id' => $request->client_id]);
        }
        if($cont_num != null ){
            Contract::where('id', $contract->id)
            ->update([
            'cont_num' => $cont_num,
            ]);

        }else{
            Contract::where('id', $contract->id)
            ->update(['cont_num' => $request->cont_num]);
        }
        if($sign_date != null ){
            Contract::where('id', $contract->id)
            ->update([
            'sign_date' => $sign_date,
            ]);

        }else{
            Contract::where('id', $contract->id)
            ->update(['sign_date' => $request->sign_date]);
        }
        if($volume != null ){
            Contract::where('id', $contract->id)
            ->update([
            'volume' => $volume,
            ]);

        }else{
            Contract::where('id', $contract->id)
            ->update(['volume' => $request->volume]);
        }
        if ($unit != null) {
            Contract::where('id', $contract->id)
            ->update([
            'unit' => $unit,
            ]);
        }else {
            Contract::where('id', $contract->id)
            ->update(['unit' => $request->unit]);
        }
        if ($price != null) {
            Contract::where('id', $contract->id)
            ->update([
            'price' => $price,
            ]);
        }else {
            Contract::where('id', $contract->id)
            ->update(['price' => $request->price]);
        }
        if ($start_date != null) {
            Contract::where('id', $contract->id)
            ->update([
            'start_date' => $start_date,
            ]);
        }else {
            Contract::where('id', $contract->id)
            ->update(['start_date' => $request->start_date]);
        }
        if ($end_date != null) {
            Contract::where('id', $contract->id)
            ->update([
            'end_date' => $end_date,
            ]);
        }else {
            Contract::where('id', $contract->id)
            ->update(['end_date' => $request->end_date]);
        }
        // if ($created_by != null) {
        //     Contract::where('id', $contract->id)
        //     ->update([
        //     'created_by' => $created_by,
        //     ]);
        // }else {
        //     Contract::where('id', $contract->id)
        //     ->update(['created_by' => $request->created_by]);
        // }

        $userid = session()->get('token')['user']['id'];
        // dd(Carbon::now());
        Contract::where('id', $contract->id)
            ->update(['updated_by' => $userid,
                      'updated_at' => Carbon::now()]);


        $files = $request->file('filename');
        if($files){
            foreach ($files as $file) {
                $filename = time().'.'.$file->getClientOriginalName();
                Contract_doc::create([
                'filename' => $filename,
                'contract_id' => $contract->id,
                ]);
                $file->move(public_path('docs'), $filename);
            }
        }
        return redirect('/contracts')->with('status', 'Data Success Change!');
    }

    public function ammend(Contract $contract)
    {
        $contracts= Contract::with('doc')->get();
        $filename = $contract->doc;
        $clients= Client::all();
        $typecek = Contract::with('type')->first();
        $types= Type::all();
        return view('contractspo.v_ammend', compact('contract', 'clients', 'filename','types','typecek'));
    }
    public function upammend(Request $request, Contract $contract)
    {
        $userid = session()->get('token')['user']['id'];
        $request->validate([
          'name' => 'required',
          'client_id' => 'required',
          'cont_num' => 'required|integer|min:1',
          'type_id' => 'required',
        //   'edit_by' => 'required|integer|min:1',
        ]);
        $validator = Validator::make($request->all(), [
        'filename.*' => 'required|mimes:pdf,xlx,csv,doc,docx',
        ]);
        if ($validator->fails()) {
            return back()
                    ->with('errorUpload', 'The file upload must be a file of type: pdf, xlx, csv, doc, docx.')
                    ->withInput();
        }

         Contract::where('id', $contract->id)
                ->update([
                'name' => $request->name,
                'client_id' => $request->client_id,
                'cont_num' => $request->cont_num,
                'volume' => $request->volume,
                'unit' => $request->unit,
                'price' => $request->price,
                'sign_date' => $request->sign_date,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                // 'created_by' => $request->edit_by,
                'updated_at' => Carbon::now(),
                'updated_by' => $userid,
                'type_id' => $request->type_id,
                ]);
        $contract->getOriginal();
        Contract_history::create([
            'changes_date' => Carbon::now(),
            'cont_id'=>$contract->getOriginal('id'),
            'name'=> $contract->getOriginal('name'),
            'cont_num' => $contract->getOriginal('cont_num'),
            'client_id' => $contract->getOriginal('client_id'),
            'volume' => $contract->getOriginal('volume'),
            'unit' => $contract->getOriginal('unit'),
            'price' => $contract->getOriginal('price'),
            'sign_date' => $contract->getOriginal('sign_date'),
            'start_date' => $contract->getOriginal('start_date'),
            'end_date' => $contract->getOriginal('end_date'),
            'created_by'=>$contract->getOriginal('created_by'),
            'created_at'=>$contract->getOriginal('created_at'),
            'edit_by'=>$userid,
            'updated_at'=> $contract->getOriginal('updated_at'),
            'type_id'=> $contract->getOriginal('type_id'),

            ]);

        $files = $request->file('filename');
        if($files){
            foreach ($files as $file) {
                $filename = time().'.'.$file->getClientOriginalName();
                Contract_doc::create([
                'filename' => $filename,
                'contract_id' => $contract->id,
                ]);
                $file->move(public_path('docs'), $filename);
            }
        }
        return redirect('/contracts')->with('status', 'Data Success Change!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract)
    {
        Contract::destroy($contract->id);
        return redirect('/contracts')->with('status', 'Success Deleting Data!');
    }

     public function destroyDoc(Contract_doc $contract_doc)
    {
        $file = Contract_doc::find($contract_doc->id);
        $filename = $contract_doc->filename;
        if(File::exists(public_path('docs/'.$filename))){
            File::delete(public_path('docs/'.$filename));
        }
        Contract_doc::destroy($contract_doc->id);
        return response()->json(['success'=>'Delete successfully.'.$filename]);
    }
}

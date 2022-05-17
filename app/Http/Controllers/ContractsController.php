<?php

namespace App\Http\Controllers;

use App\Models\Blanket;
use App\Models\Blanket_history;
use App\Models\Contract;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Contract_history;
use App\Models\Contract_doc;
use App\Models\Global_quantity;
use App\Models\Global_quantity_history;
use App\Models\Global_total_value;
use App\Models\Type;
use App\Models\Viewable;
use Carbon\Carbon;
use File;
// use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

use function GuzzleHttp\Promise\all;

class ContractsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contracts= Contract::with('client','his')->get();
        // dd($contracts);
        return view('contracts.v_index', compact('contracts'));
    }

    public function history_show($id){

        $contracthislis = Contract_history::with('client')->where('id',$id)->get();
        // dd($contracthislis);
        return view('contracts.v_show_history', compact('contracthislis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $response = Http::get('http://usersmanage.adi-internal.com/api/auth/getrolluser');
        $roleUser = json_decode((string) $response->body(), true);
        $ListroleUser = $roleUser['RoleUser'];
        // dd(count($roleUser['RoleUser']));
        // foreach ($ListroleUser as $key => $value) {
        //     dd($value['name']);
        // }
        $clients= Client::all();
        $types= Type::all();
        $typecek = Contract::with('type')->first();
        return view('contracts.create', compact('clients','types','typecek','ListroleUser'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->all());

        $request->validate([
        'name' => 'required',
        'client_id' => 'required',
        // 'cont_num' => 'required|min:1',
        // 'type_id' => 'required'
        ]);
        // $validator = Validator::make($request->all(), [
        // 'filename.*' => 'required|mimes:pdf,xlx,csv,doc,docx',
        // ]);
        // if ($validator->fails()) {
        //              return back()
        //                     ->with('errorUpload', 'The file upload must be a file of type: pdf, xlx, csv, doc, docx.')
        //                     ->withInput();
        // }
        if($request->type == 1){
            $request->validate([
                'desc' => 'required',
                'volume' => 'required',
                'price' => 'required',
                ]);
        }

        $userid = session()->get('token')['user']['id'];
        $request->merge([
         'created_by' => $userid,
        ]);

        //rp
        if ($request->has('price')) {
            # code...
            $pricereq = count($request->price);
            for ($i=0; $i < $pricereq; $i++) {
                $price_str = preg_replace("/[^0-9]/", "" , $request->price[$i]);
                $price_int = (int)$price_str;
                $pricecoll[] = $price_int;
            }
            $request->merge([
                'price2' => $pricecoll
            ]);
        }
	    // dd($request->all());
        $contractCreate = Contract::create([
            'name' => $request->name,
            'cont_num' => $request->cont_num,
            'client_id' => $request->client_id,
            'sign_date' => $request->sign_date,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type_id' => $request->type,
            'created_by' => $request->created_by,
            ])->id;

        if ($request->type == 1) {
            //blanket
                    if ($request->desc[0] != null ) {
                        $blanketList = count($request->desc);
                        for ($i=0; $i < $blanketList; $i++) {
                            // dd($request->desc[$i]);
                        $createblanket = Blanket::create([
                            'contract_id' => $contractCreate,
                            'desc' => $request->desc[$i],
                            'satuan' => $request->satuan[$i],
                            'volume' => $request->volume[$i],
                            'price' => $request->price2[$i],
                        ]);
                        }
                    }
            }elseif($request->type == 2){
                //global quantity
                $qtyG = Global_quantity::create([
                    'quantity' => $request->quantity
                ])->id;
                foreach ($request->desc as $key => $vdesc) {
                    Blanket::create([
                        'contract_id' => $contractCreate,
                        'desc' => $vdesc,
                        'satuan' => $request->satuan[$key],
                        'price' => $request->price2[$key],
                        'global_quantity_id' => $qtyG,
                    ]);
                }

            }elseif($request->type == 3){
                //global total value
                $value_str = preg_replace("/[^0-9]/", "" , $request->value);
                $value_int = (int)$value_str;

                $valueG = Global_total_value::create([
                    'total_value' => $value_int
                ])->id;
                foreach ($request->desc as $key => $vdesc) {
                    Blanket::create([
                        'contract_id' => $contractCreate,
                        'desc' => $vdesc,
                        'satuan' => $request->satuan[$key],
                        'price' => $request->price2[$key],
                        'global_total_value_id' => $valueG,
                    ]);
                }
            }else{
                // $request->merge([
                //     'type_id' => $request->type,
                //    ]);
                // //except = kecuali
                // $contract = Contract::create($request->except([
                //     'type','desc','volume','price'
                //   ]));
            }

            if (!empty($request->userview)) {
                foreach ($request->userview as $key => $idv) {
                    Viewable::create([
                        'user_id' => $idv,
                        'contract_id' => $contractCreate,
                    ]);
                }
            }else{
                Viewable::create([
                    'user_id' => null,
                    'contract_id' => $contractCreate,
                ]);
            }

            $files = $request->file('filename');
                if($files){
                    foreach ($files as $file) {
                        $filename = time().'.'.$file->getClientOriginalName();
                        Contract_doc::create([
                        'filename' => $filename,
                        'contract_id' => $contractCreate,
                        ]);
                        $file->move(public_path('docs'), $filename);
                    }
                }
        return redirect('/contractProjects')->with('status', 'Success add Contract!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract)
    {
        $filename =$contract->doc;
        // $blankets =$contract->blanket::with('g_quantity','g_total_value');
        $blankets = Blanket::with('g_quantity','g_total_value')->where('contract_id',$contract->id)->get();
        $clients= Client::all();

        // dd($blankets);
        return view('contracts.show', compact('contract', 'clients', 'blankets', 'filename'));
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
        $blankets = Blanket::with('g_quantity','g_total_value')->where('contract_id',$contract->id)->get();
        // dd($blankets);
        $types= Type::all();
        return view('contracts.edit', compact('contract', 'clients', 'filename','blankets','types','typecek'));
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
        // $validator = Validator::make($request->all(), [
        // 'filename.*' => 'required|mimes:pdf,xlx,csv,doc,docx',
        // ]);
        // if ($validator->fails()) {
        //     return back()
        //             ->with('errorUpload', 'The file upload must be a file of type: pdf, xlx, csv, doc, docx.')
        //             ->withInput();
        // }
        // dd($request->all());
        $newType_id = $request->get('type');
        $dataOlds =Contract::all();
        // dd($dataOlds);
        foreach($dataOlds as $dataold){
            if($dataold->id==$contract->id){
                $name= $dataold->name;
                $client_id= $dataold->client_id;
                $cont_num= $dataold->cont_num;
                $sign_date= $dataold->sign_date;
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
        if ($created_by != null) {
            Contract::where('id', $contract->id)
            ->update([
            'created_by' => $created_by,
            ]);
        }else {
            Contract::where('id', $contract->id)
            ->update(['created_by' => $request->created_by]);
        }

        $userid = session()->get('token')['user']['id'];
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
        return redirect('/contractProjects')->with('status', 'Data Success Change!');
    }

    public function ammend(Contract $contract)
    {
        $contracts= Contract::with('doc','type')->get();
        $filename = $contract->doc;
        $clients= Client::all();
        $typecek = Contract::with('type')->first();
        $types= Type::all();

        // $blankets =$contract->blanket;
        $blankets = Blanket::with('g_quantity','g_total_value')->where('contract_id',$contract->id)->get();

        // dd();
        return view('contracts.ammend', compact('contract', 'clients', 'filename','blankets','types','typecek'));
    }
    public function upammend(Request $request, Contract $contract)
    {
        $userid = session()->get('token')['user']['id'];
        $request->validate([
          'name' => 'required',
          'client_id' => 'required',
        //   'cont_num' => 'required|integer|min:1',
        //   'type_id' => 'required',
        //   'edit_by' => 'required|integer|min:1',
        ]);

        // $validator = Validator::make($request->all(), [
        // 'filename.*' => 'required|mimes:pdf,xlx,csv,doc,docx',
        // ]);
        // if ($validator->fails()) {
        //     return back()
        //             ->with('errorUpload', 'The file upload must be a file of type: pdf, xlx, csv, doc, docx.')
        //             ->withInput();
        // }
        $OldBlanketRecord =  Blanket::with('g_quantity','g_total_value')->where('contract_id', $contract->id)->get();
        $OldBlanketRecordOne =  Blanket::with('g_quantity','g_total_value')->where('contract_id', $contract->id)->first();
        // dd($OldBlanketRecord);
        // dd($request->all());
        if ($request->type_reqblanket == '1') {
            if ($request->price[0] != 'null') {
                # code...
                $pricereq = count($request->price);
                for ($i=0; $i < $pricereq; $i++) {
                    $price_str = preg_replace("/[^0-9]/", "" , $request->price[$i]);
                    $price_int = (int)$price_str;
                    $pricecoll[] = $price_int;
                }
                $request->merge([
                    'price2' => $pricecoll
                ]);
            }

            $checkGlobal = Blanket::with('g_quantity','g_total_value')->where('contract_id', $contract->id)->first();
            if ($request->type_name == "Blanket") {
                // dd($request->all());
                foreach ($request->desc as $key => $value) {
                    if (isset($request->blanket_id[$key])) {
                        Blanket::where('id',$request->blanket_id[$key])->update([
                            'contract_id' => $request->id,
                            'desc' => $value,
                            'satuan' => $request->satuan[$key],
                            'volume' => $request->volume[$key],
                            'price' => $request->price2[$key],
                        ]);
                    }else{
                        Blanket::create([
                            'contract_id' => $request->id,
                            'desc' => $value,
                            'satuan' => $request->satuan[$key],
                            'volume' => $request->volume[$key],
                            'price' => $request->price2[$key],
                        ]);
                    }
                }
            }elseif ($request->type_name == "Blanket Quantity Global") {
                if ($request->quantity != $checkGlobal->g_quantity->quantity) {
                    Global_quantity::where('id',$checkGlobal->g_quantity->id)->update([
                        'quantity' => $request->quantity,
                    ]);
                }
                foreach ($request->desc as $key => $value) {
                    if (isset($request->blanket_id[$key])) {
                        Blanket::where('id',$request->blanket_id[$key])->update([
                            'contract_id' => $request->id,
                            'desc' => $value,
                            'satuan' => $request->satuan[$key],
                            'global_quantity_id' => $checkGlobal->g_quantity->id,
                            'price' => $request->price2[$key],
                        ]);
                    }else{
                        Blanket::create([
                            'contract_id' => $request->id,
                            'desc' => $value,
                            'satuan' => $request->satuan[$key],
                            'global_quantity_id' => $checkGlobal->g_quantity->id,
                            'price' => $request->price2[$key],
                        ]);
                    }
                }
            }elseif ($request->type_name == "Blanket Total Value Global") {
                $total_str = preg_replace("/[^0-9]/", "" , $request->value);
                if ($total_str != $checkGlobal->g_total_value->total_value) {
                    Global_total_value::where('id',$checkGlobal->g_total_value->id)->update([
                        'total_value' => (int)$total_str,
                    ]);
                }
                foreach ($request->desc as $key => $value) {
                    if (isset($request->blanket_id[$key])) {
                        Blanket::where('id',$request->blanket_id[$key])->update([
                            'contract_id' => $request->id,
                            'desc' => $value,
                            'satuan' => $request->satuan[$key],
                            'global_quantity_id' => $checkGlobal->g_total_value->id,
                            'price' => $request->price2[$key],
                        ]);
                    }else{
                        Blanket::create([
                            'contract_id' => $request->id,
                            'desc' => $value,
                            'satuan' => $request->satuan[$key],
                            'global_quantity_id' => $checkGlobal->g_total_value->id,
                            'price' => $request->price2[$key],
                        ]);
                    }
                }
            }
        }
        // dd($request->all());
         Contract::where('id', $contract->id)
                ->update([
                'name' => $request->name,
                'client_id' => $request->client_id,
                'cont_num' => $request->cont_num,
                'sign_date' => $request->sign_date,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'updated_at' => Carbon::now(),
                'updated_by' => $userid,
                'type_id' => $request->type_id,
                ]);
        $contract->getOriginal();
        $getIdHistory = Contract_history::create([
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
            ])->id;

            if ($OldBlanketRecordOne->g_quantity != null) {
                $qtyID = Global_quantity_history::create([
                    'global_quantity_id' => $OldBlanketRecordOne->g_quantity->id,
                    'quantity' => $OldBlanketRecordOne->g_quantity->quantity,
                ])->id;
                foreach ($OldBlanketRecord as $key => $value) {
                    Blanket_history::create([
                        'changes_date' => Carbon::now(),
                        'contract_history_id' => $getIdHistory,
                        'desc' => $value->desc,
                        'satuan' => $value->satuan,
                        'global_quantity_history_id' => $qtyID,
                        'price' => $value->price,
                    ]);
                }
            }elseif ($OldBlanketRecordOne->g_total_value != null) {
                $valID = Global_quantity_history::create([
                    'global_total_value_id' => $OldBlanketRecordOne->g_total_value->id,
                    'total_value' => $OldBlanketRecordOne->g_total_value->total_value,
                ])->id;
                foreach ($OldBlanketRecord as $key => $value) {
                    Blanket_history::create([
                        'changes_date' => Carbon::now(),
                        'contract_history_id' => $getIdHistory,
                        'desc' => $value->desc,
                        'satuan' => $value->satuan,
                        'global_total_value_history_id' => $valID,
                        'price' => $value->price,
                    ]);
                }
            }else{
                foreach ($OldBlanketRecord as $key => $value) {
                    Blanket_history::create([
                        'changes_date' => Carbon::now(),
                        'contract_history_id' => $getIdHistory,
                        'desc' => $value->desc,
                        'satuan' => $value->satuan,
                        'volume' => $value->volume,
                        'price' => $value->price,
                    ]);
                }
            }


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
        return redirect('/contractProjects')->with('status', 'Data Success Change!');

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
        return redirect('/contractProjects')->with('status', 'Success Deleting Data!');
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

<?php

namespace App\Http\Controllers;

use App\Models\Progress_item;
use App\Models\Progress_status;
use Illuminate\Http\Request;

class Progress_statusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $p = Progress_item::whereNotNull('status_id')->whereNull('invoice_status_id')->get();
        // // dd($p->name_progress);
        // foreach($p as $ps){
        //     echo $ps->name_progress;
        //     echo ' <br> ';
            // print_r($ps->name_progress);
        // }

       $progress_status= Progress_status::all();
       return view('status.v_index', compact('progress_status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('status.v_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userid = session()->get('token')['user']['id'];
        $request->merge([
            'created_by' => $userid,
        ]);
        Progress_status::create($request->all());
        return redirect('/progress_status')->with('status', 'Success create status');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Progress_status  $progress_status
     * @return \Illuminate\Http\Response
     */
    public function show(Progress_status $progress_status)
    {
        return view('status.v_show', compact('progress_status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Progress_status  $progress_status
     * @return \Illuminate\Http\Response
     */
    public function edit(Progress_status $progress_status)
    {
        //return $progress_status;

        return view('status.v_edit', compact('progress_status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Progress_status  $progress_status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Progress_status $progress_status)
    {
        $userid = session()->get('token')['user']['id'];
        $request->merge([
            'updated_by' => $userid,
        ]);
        Progress_status::where('id', $progress_status->id)->update([
            'status' => $request->status,
            'updated_by' => $request->updated_by,
            ]);
        return redirect('/progress_status')->with('status', 'Success update status!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Progress_status  $progress_status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Progress_status $progress_status)
    {
        Progress_status::destroy($progress_status->id);
        return redirect('/progress_status')->with('status', 'Success delete status!');
    }
}

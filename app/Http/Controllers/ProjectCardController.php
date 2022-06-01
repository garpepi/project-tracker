<?php

namespace App\Http\Controllers;

use App\Exports\ProjectCardExport;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\Project_cost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProjectCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projectcard = Project::with('contract')->withCount(['actual_payment as actualPay' =>
        function($query)
        {
            $query->select(DB::raw('SUM(amount)'));
        }])->withCount(['project_cost as totalcost' =>
        function($query)
        {
            $query->select(DB::raw('SUM(budget_of_quantity)'));
        }])->orderBy('id', 'desc')->get();
        return view('project-card.index',compact('projectcard'));
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
    public function show($id)
    {
        $projectcarddetail = Project::with('contract')->withCount(['actual_payment as actualPay' =>
        function($query)
        {
            $query->select(DB::raw('SUM(amount)'));
        }])->withCount(['project_cost as totalcost' =>
        function($query)
        {
            $query->select(DB::raw('SUM(budget_of_quantity)'));
        }])->where('id',$id)->first();

        $invoice = Invoice::with('progress_item','tax_proof','actual_payment')->withCount(['actual_payment as actualPay' =>
        function($query)
        {
            $query->select(DB::raw('SUM(amount)'));
        }])->withCount(['tax_proof as percentagetax' =>
        function($query)
        {
            $query->select(DB::raw('SUM(percentage)'));
        }])->where('project_id',$id)->get();

        $projectcost = Project_cost::with('progress_item','suplier')->where('project_id',$id)->get();
        // dd($invoice);

        return view('project-card.show',compact('projectcarddetail','invoice','projectcost'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    public function export(Request $request,$id)
        {
            return Excel::download(new ProjectCardExport($id), 'projectcard.xlsx');
        }
}

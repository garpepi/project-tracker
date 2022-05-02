<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Projects_statusController extends Controller
{
    public function index()
    {
       $projects_status= DB::table('projects')
       ->join('progress_items', 'projects.id', '=', 'progress_items.project_id')
       ->select('projects.name','projects.no_po',
       DB::raw('SUM(IF(IFNULL(NULL,progress_items.status_id), progress_items.payment_percentage,0)) AS status'),
       DB::raw('SUM(IF(IFNULL(NULL,progress_items.invoice_status_id), progress_items.payment_percentage,0)) AS invoice_status') 
       )
       ->groupBy('projects.no_po')->groupBy('projects.name')
       ->get();
       return view('projects.status.v_index', compact('projects_status'));
    }
}

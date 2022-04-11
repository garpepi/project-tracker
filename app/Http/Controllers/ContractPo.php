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
class ContractPo extends Controller
{
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

        return view('contract-po.index', compact('contracts','projects'));
    }
}

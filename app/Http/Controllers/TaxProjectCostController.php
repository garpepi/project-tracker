<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Actual_payable_payed;
use App\Models\Project_cost;
use App\Models\Tax_project_cost;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class TaxProjectCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show(Request $request, $id)
    {
        // if ($request->has('urlname')) {
            if ($request->urlname == 'setppn10') {
                Tax_project_cost::create([
                    'project_cost_id' => $request->id,
                    'project_id' => $request->project_id,
                    'tax_id' => 1,
                    'percentage' => $request->percentage,
                ]);
                return response()->json([
                    'success' => 'ok'
                ]);
            }
        // }
        if ($request->urlname == "checkppn") {
            $checkppn = Tax_project_cost::where('project_cost_id',$id)->where('tax_id',1)->first();
            $checkpaid = Actual_payable_payed::where('project_cost_id',$id)->first();
            if (empty($checkppn) && empty($checkpaid)) {
                return response()->json([
                    'ppnavailable' => 'yes'
                ]);
            }else{
                return response()->json([
                    'ppnavailable' => 'no'
                ]);
            }
        }
        if ($request->urlname == "projectcostwithtax") {
            $dpp = 0;
            $taxPPH23 = null;
            $tr = array();
            $taxuse = null;
            $taxprojectcost = Tax_project_cost::with('project_cost','tax')->where('project_cost_id',$id)->get();
            $taxprojectcostcek = Tax_project_cost::with('project_cost','tax')->where('project_cost_id',$id)->first();
            if (empty($taxprojectcostcek)) {
                $taxuse = "empty";
            }else{
                $taxuse = "filled";
            }
            foreach ($taxprojectcost as $key => $value) {
                if ($value->tax_id == 1) {
                    $ppn = $value->project_cost->budget_of_quantity * ($value->percentage / 100);
                    $dpp = $value->project_cost->budget_of_quantity - $ppn;
                    break;
                }
            }
            foreach ($taxprojectcost as $key => $data) {

                if ($data->tax->name == "PPN") {
                    $taxcount = $data->project_cost->budget_of_quantity * ($data->percentage / 100);
                    $tr[] = "<tr>
                    <td class='col-3'>
                    <input type='hidden' name='tax_project_cost_id[]' value='".$data->id."'>
                        <select name='tax[]' class='form-control select2' style='width: 100%' readonly>
                            <option selected value='".$data->tax->id."'> ".$data->tax->name." </option>
                        </select>
                    </td>
                    <td class='col-2'><input type='text' name='percentage[]' placeholder='e.g 1.0' class='form-control text-right' value='".round($data->percentage)."' readonly/>
                    </td>
                    <td><input type='text' id='total_tax' name='total_tax[]' class='form-control text-right' value='Rp. ".number_format($taxcount,0,',','.') ."' readonly/>
                    </td>
                     </tr>";
                }elseif ($data->tax->name = "PPH 23") {
                    $taxPPH23 = $dpp * ($data->percentage / 100);
                    $tr[] = "<tr>
                    <td class='col-3'>
                    <input type='hidden' name='tax_project_cost_id[]' value='".$data->id."'>
                        <select name='tax[]' class='form-control select2' style='width: 100%' readonly>
                            <option selected value='".$data->tax->id."'> ".$data->tax->name." </option>
                        </select>
                    </td>
                    <td class='col-2'><input type='text' name='percentage[]' placeholder='e.g 1.0' class='form-control text-right' value='".round($data->percentage)."' readonly/>
                    </td>
                    <td><input type='text' id='total_tax' name='total_tax[]' class='form-control text-right' value='Rp. ".number_format($taxPPH23,0,',','.') ."' readonly/>
                    </td>
                     </tr>";
                }

                    }
            $projectcostlist = Project_cost::with('tax_project_cost','suplier')->where('id',$id)->get();
            $checkpaid = Actual_payable_payed::where('project_cost_id',$id)->get();
            // dd($projectcost->tax_project_cost[0]->tax->name);


            return response()->json([
                'taxuse' => $taxuse,
                'dpp' => 'Rp. '.number_format($dpp,0,',','.'),
                'tr' => $tr,
                'taxPPH23' => $taxPPH23,
            ]);
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
}

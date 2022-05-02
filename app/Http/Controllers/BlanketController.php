<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blanket;
use App\Models\Project;
use App\Models\Useblanket;
use Illuminate\Http\Request;

class BlanketController extends Controller
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
    public function show(Request $request)
    {
        $blanketList = Blanket::with('g_quantity','g_total_value')->withSum('useblanket as blanket_use_volume','use_volume')->where('contract_id',$request->id)->get();
        // dd();
        $blanketListlength = count($blanketList);
        $blength = count($blanketList);
        $tr = array();
        $global = [];
        $sumQty = null;
        $project_sum = Project::where('contract_id',$request->id)->groupBy('contract_id')->sum('total_price');
        // dd($project_sum);

        foreach ($blanketList as $key => $item) {
            // dd($item->g_quantity);
            if ($item->g_quantity != null) {
                $global = [
                    'name' => 'global quantity',
                    'value' => $item->g_quantity->quantity,
                    // 'value' => $item->blanket_use_volume,
                ];
                $sumQty[] = $item->blanket_use_volume;
                // break;
            }
            elseif ($item->g_total_value != null) {
                $setRP = '';
                if ($project_sum != 0) {
                    $countRp = $item->g_total_value->total_value - (int)$project_sum;
                    $setRP = number_format($countRp,0,',','.');
                }else {
                    $setRP = number_format($item->g_total_value->total_value,0,',','.');
                }
                $global = [
                    'name' => 'global total value',
                    'value' => 'Rp. '.$setRP,
                ];
                // break;
            }

            $checkvolumeavailable =  $item->volume -  (int)$item->blanket_use_volume;
            if ($checkvolumeavailable > 0 || $item->g_quantity != null || $item->g_total_value != null) {
                if ($item->g_quantity != null || $item->g_total_value != null) {
                    $tr[] = '<tr><td> <input type="hidden" name="blanketid[]" value="' . $item->id .'"/>
                    <input readonly type="text" name="descb[]" value="' . $item->desc .
                    '" placeholder="Enter Desc" class="form-control" /></td>
                    <td><input id="satuan'. $key .'" readonly type="text" name="satuan[]" value="' . $item->satuan .
                    '" placeholder="Enter Satuan" class="form-control" /> </td>
                    <td><input id="price'. $key .'" readonly type="text" name="price[]" value="Rp. ' .number_format($item->price,0,',','.')  .
                    '" placeholder="Total cost" class="form-control" /></td>
                    <td><input required id="volume_use'. $key .'" onchange="math('. $key .',' . $blength .')" type="number" name="volume_use[]" value=""
                    placeholder="Enter volume use " class="form-control" />
                    <input type="hidden" id="setvalue'. $key .'" value="0" /></td>
                    </tr>';
                }else {
                    $tr[] = '<tr><td> <input type="hidden" name="blanketid[]" value="' . $item->id .'"/>
                        <input readonly type="text" name="descb[]" value="' . $item->desc .
                        '" placeholder="Enter Desc" class="form-control" /></td>
                        <td><input id="satuan'. $key .'" readonly type="text" name="satuan[]" value="' . $item->satuan .
                        '" placeholder="Enter Satuan" class="form-control" /> </td>
                        <td><input id="volume'. $key .'" readonly type="text" name="volume[]" value="' . $checkvolumeavailable .
                        '" placeholder="Enter Volume" class="form-control" /> </td>
                        <td><input id="price'. $key .'" readonly type="text" name="price[]" value="Rp. ' .number_format($item->price,0,',','.')  .
                        '" placeholder="Total cost" class="form-control" /></td>
                        <td><input required id="volume_use'. $key .'" onchange="math('. $key .',' . $blength .')" type="number" name="volume_use[]" value=""
                        placeholder="Enter volume use " class="form-control" />
                        <input type="hidden" id="setvalue'. $key .'" value="0" /></td>
                        </tr>';
                    }
            }
        }

        //masukin nilai yang sudah ada
        if ($sumQty != null) {
            $a = $global['value'];
            $b = array_sum($sumQty);
            $v = $a - $b;
            foreach ($global as $key => $value) {
                $global2 = [
                    'name' => 'global quantity',
                    'value' =>  $v,
                ];
            }
            $global =  array_replace($global,$global2);
        }


        // if ($useblanket->get_total != null) {
        //     dd($useblanket->get_total);
        //     // dd($getTotalValueALL);
        // }
        // dd(array_sum($sumQty));
        // dd($global);

        return response()->json([
            'global' => $global,
            'length' => $blanketListlength,
            'blanket' => $tr,
            // 'checkV' => $checkvolumeavailable,
        ]);
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

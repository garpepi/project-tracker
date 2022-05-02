<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blanket;
use App\Models\Project;
use App\Models\Useblanket;
use Illuminate\Http\Request;

class UseblanketController extends Controller
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
        if ($request->url == "ammend") {
            $blanketList = Blanket::with('useblanket','g_quantity','g_total_value')->withSum('useblanket as blanket_use_volume', 'use_volume')->where('contract_id',$request->contract_id)->get();
            $blanketListGetFirst = Blanket::with('useblanket','g_quantity','g_total_value')->withSum('useblanket as blanket_use_volume', 'use_volume')->where('contract_id',$request->contract_id)->first();
            $textrow = Useblanket::with('blanket','blanket.g_quantity','blanket.g_total_value')->select('*')->where('project_id',$request->id)->get();
            $blanketListlength = count($blanketList);
            $blength = count($blanketList);
            $tr = array();
            $checkGlobal = null;
            $project_sum = Project::where('contract_id',$request->contract_id)->groupBy('contract_id')->sum('total_price');
            $sumValue = null;
            $volumeUseAll = null;
            $volumeUseQty = null;

            if ($blanketListGetFirst->g_quantity != null ) {
                      foreach ($blanketList as $key => $val) {
                            $volumeUseAll[] = $val->blanket_use_volume;
                        }
            }

            foreach ($textrow as $key => $item) {
                $volumeuse = 0;
                foreach ($blanketList as $keyx => $value) {
                    if ($value->id == $item->blanket_id ) {
                        if ($value->volume != null) {
                            $volumeuse = $value->volume;
                            $total_volume = $volumeuse - $value->blanket_use_volume;
                            break;
                        }
                    }
                }
                if ($item->blanket->global_quantity_id != null) {
                    $checkGlobal = 'global quantity';
                    $getValue = $item->blanket->g_quantity->quantity;
                    $volumeUseQty[] = $item->use_volume;
                    $tr[] = '<tr><td> <input type="hidden" name="useblanketId[]" value=" '. $item->id .'"/>
                    <input readonly type="text" name="descb[]" value="' . $item->blanket->desc .
                    '" placeholder="Enter Desc" class="form-control" /></td>
                    <td><input id="satuan'. $key .'" readonly type="text" name="satuan[]" value="'. $item->blanket->satuan .
                    '" placeholder="Enter satuan" class="form-control" /> </td>
                    <td><input id="price'. $key .'" readonly type="text" name="price[]" value="Rp. ' .number_format($item->blanket->price,0,',','.')  .
                    '" placeholder="Total cost" class="form-control" /></td>
                    <td><input required id="volume_use'. $key .'" onchange="math('. $key .',' . $blength .')" type="number" name="volume_use[]" value="'.(int)$item->use_volume.'"
                    placeholder="Enter volume use " class="form-control" />
                    <input type="hidden" id="setvalue'. $key .'" value="0" /></td>
                    </tr>';
                }elseif ($item->blanket->global_total_value_id != null) {
                    $checkGlobal = 'global total value';
                    $getValue = $item->blanket->g_total_value->total_value - $project_sum;
                    $globalVal = 'Rp. '. number_format($getValue,0,',','.');

                    $tr[] = '<tr><td> <input type="hidden" name="useblanketId[]" value=" '. $item->id .'"/>
                    <input readonly type="text" name="descb[]" value="' . $item->blanket->desc .
                    '" placeholder="Enter Desc" class="form-control" /></td>
                    <td><input id="satuan'. $key .'" readonly type="text" name="satuan[]" value="'. $item->blanket->satuan .
                    '" placeholder="Enter satuan" class="form-control" /> </td>
                    <td><input id="price'. $key .'" readonly type="text" name="price[]" value="Rp. ' .number_format($item->blanket->price,0,',','.')  .
                    '" placeholder="Total cost" class="form-control" /></td>
                    <td><input required id="volume_use'. $key .'" onchange="math('. $key .',' . $blength .')" type="number" name="volume_use[]" value="'.(int)$item->use_volume.'"
                    placeholder="Enter volume use " class="form-control" />
                    <input type="hidden" id="setvalue'. $key .'" value="0" /></td>
                    </tr>';

                }else {
                    $globalVal = null;
                    $tr[] = '<tr><td> <input type="hidden" name="useblanketId[]" value=" '. $item->id .'"/>
                        <input readonly type="text" name="descb[]" value="' . $item->blanket->desc .
                        '" placeholder="Enter Desc" class="form-control" /></td>
                        <td><input id="satuan'. $key .'" readonly type="text" name="satuan[]" value="'. $item->blanket->satuan .
                        '" placeholder="Enter satuan" class="form-control" /> </td>
                        <td><input id="volume'. $key .'" readonly type="text" name="volume[]" value="'. $total_volume + (int)$item->use_volume .
                        '" placeholder="Enter Volume" class="form-control" /> </td>
                        <td><input id="price'. $key .'" readonly type="text" name="price[]" value="Rp. ' .number_format($item->blanket->price,0,',','.')  .
                        '" placeholder="Total cost" class="form-control" /></td>
                        <td><input required id="volume_use'. $key .'" onchange="math('. $key .',' . $blength .')" type="number" name="volume_use[]" value="'.(int)$item->use_volume.'"
                        placeholder="Enter volume use " class="form-control" />
                        <input type="hidden" id="setvalue'. $key .'" value="0" /></td>
                        </tr>';
                }

            }
            // dd($sumValue);
            if ($volumeUseAll != null) {
                $vua = array_sum($volumeUseAll);
                $vuq = array_sum($volumeUseQty);
                $sumvu = $vua - $vuq;
                if ($sumvu != 0) {
                    $globalVal = $getValue - $sumvu;
                }else{
                    $globalVal = $getValue;
                }
            }
            return response()->json([
                // 'length' => $blanketListlength,
                'blanket' => $tr,
                'typename' => $checkGlobal,
                'value' => $globalVal,
                // 'testrow' => $textrow
            ]);
        }
        if ($request->url == "show") {
            $blanketList = Blanket::with('useblanket','g_quantity','g_total_value')->withSum('useblanket as blanket_use_volume', 'use_volume')->where('contract_id',$request->contract_id)->get();
            $blanketListGetFirst = Blanket::with('useblanket','g_quantity','g_total_value')->withSum('useblanket as blanket_use_volume', 'use_volume')->where('contract_id',$request->contract_id)->first();
            $textrow = Useblanket::with('blanket','blanket.g_quantity','blanket.g_total_value')->select('*')->where('project_id',$request->id)->get();
            $blanketListlength = count($blanketList);
            $blength = count($blanketList);
            $tr = array();
            $checkGlobal = null;
            $project_sum = Project::where('contract_id',$request->contract_id)->groupBy('contract_id')->sum('total_price');
            $volumeUseAll = null;
            // $sumValue = null;

            if ($blanketListGetFirst->g_quantity != null ) {
                foreach ($blanketList as $key => $val) {
                      $volumeUseAll[] = $val->blanket_use_volume;
                  }
             }
            foreach ($textrow as $key => $item) {
                $volumeuse = 0;
                $volumeAll = 0;
                foreach ($blanketList as $key => $value) {
                    if ($value->id == $item->blanket_id ) {
                        if ($value->volume != null) {
                            $volumeuse = $value->volume;
                            $total_volume = $volumeuse - $value->blanket_use_volume;
                            break;
                        }
                    }
                }
                // dd($item->blanket->global_quantity_id);
                if ($item->blanket->global_quantity_id != null) {
                    // dd($item->blanket);
                    $checkGlobal = 'global quantity';
                    $getValue = $item->blanket->g_quantity->quantity;
                    // $sumValue = $volumeAll;
                    $tr[] = '<tr><td> <input type="hidden" name="useblanketId[]" value=" '. $item->id .'"/>
                    <input readonly type="text" name="descb[]" value="' . $item->blanket->desc .
                    '" placeholder="Enter Desc" class="form-control" /></td>
                    <td><input id="satuan'. $key .'" readonly type="text" name="satuan[]" value="'. $item->blanket->satuan .
                    '" placeholder="Enter satuan" class="form-control" /> </td>
                    <td><input id="price'. $key .'" readonly type="text" name="price[]" value="Rp. ' .number_format($item->blanket->price,0,',','.')  .
                    '" placeholder="Total cost" class="form-control" /></td>
                    <td><input readonly id="volume_use'. $key .'" onchange="math('. $key .',' . $blength .')" type="number" name="volume_use[]" value="'.(int)$item->use_volume.'"
                    placeholder="Enter volume use " class="form-control" />
                    <input type="hidden" id="setvalue'. $key .'" value="0" /></td>
                    </tr>';
                }elseif ($item->blanket->global_total_value_id != null) {
                    $checkGlobal = 'global total value';
                    $getValue = $item->blanket->g_total_value->total_value - $project_sum;
                    $globalVal = 'Rp. '. number_format($getValue,0,',','.');

                    $tr[] = '<tr><td> <input type="hidden" name="useblanketId[]" value=" '. $item->id .'"/>
                    <input readonly type="text" name="descb[]" value="' . $item->blanket->desc .
                    '" placeholder="Enter Desc" class="form-control" /></td>
                    <td><input id="satuan'. $key .'" readonly type="text" name="satuan[]" value="'. $item->blanket->satuan .
                    '" placeholder="Enter satuan" class="form-control" /> </td>
                    <td><input id="price'. $key .'" readonly type="text" name="price[]" value="Rp. ' .number_format($item->blanket->price,0,',','.')  .
                    '" placeholder="Total cost" class="form-control" /></td>
                    <td><input readonly id="volume_use'. $key .'" onchange="math('. $key .',' . $blength .')" type="number" name="volume_use[]" value="'.(int)$item->use_volume.'"
                    placeholder="Enter volume use " class="form-control" />
                    <input type="hidden" id="setvalue'. $key .'" value="0" /></td>
                    </tr>';

                }else {
                    $globalVal = null;
                    $tr[] = '<tr><td> <input type="hidden" name="useblanketId[]" value=" '. $item->id .'"/>
                        <input readonly type="text" name="descb[]" value="' . $item->blanket->desc .
                        '" placeholder="Enter Desc" class="form-control" /></td>
                        <td><input id="satuan'. $key .'" readonly type="text" name="satuan[]" value="'. $item->blanket->satuan .
                        '" placeholder="Enter satuan" class="form-control" /> </td>
                        <td><input id="volume'. $key .'" readonly type="text" name="volume[]" value="'. $total_volume .
                        '" placeholder="Enter Volume" class="form-control" /> </td>
                        <td><input id="price'. $key .'" readonly type="text" name="price[]" value="Rp. ' .number_format($item->blanket->price,0,',','.')  .
                        '" placeholder="Total cost" class="form-control" /></td>
                        <td><input readonly id="volume_use'. $key .'" onchange="math('. $key .',' . $blength .')" type="number" name="volume_use[]" value="'.(int)$item->use_volume.'"
                        placeholder="Enter volume use " class="form-control" />
                        <input type="hidden" id="setvalue'. $key .'" value="0" /></td>
                        </tr>';
                }

            }
            // dd($sumValue);
            if ($volumeUseAll != null) {
                $globalVal = $getValue - array_sum($volumeUseAll);
            }
            return response()->json([
                // 'length' => $blanketListlength,
                'blanket' => $tr,
                'typename' => $checkGlobal,
                'value' => $globalVal,
                // 'testrow' => $textrow
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

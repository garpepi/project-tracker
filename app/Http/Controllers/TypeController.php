<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TypeController extends Controller
{
    public function index()
    {
        $types = Type::all();
        return view('config.typecontract.v_index', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'display' => 'required',
            // 'required' => 'required'
           ]);
        $userid = session()->get('token')['user']['id'];
        $request->merge([
            'created_by' => $userid,
        ]);
        if ($request->required == null) {
            $request->merge([
                'required' => 0,
            ]);
        }else{
            $request->merge([
                'required' => 1,
            ]);
        }

        Type::create($request->all());
        // dd($request->all());
        Alert::toast('create data success', 'success');
        return redirect('/types');
    }

    public function update(Request $request)
    {
        // dd($request->required);
        $userid = session()->get('token')['user']['id'];
        $request->merge([
            'updated_by' => $userid,
        ]);
        if ($request->required != null) {
            $request->merge([
                'required' => 1,
            ]);
        }else{
            $request->merge([
                'required' => 0,
            ]);
        }
        $updateType = $request->except('_method', '_token');
        Type::where('id', $request->id)->update($updateType);
        Alert::toast('Success editing data', 'success');
        return redirect('/types');
    }

    public function destroy(Type $type)
    {
        Type::destroy($type->id);
        Alert::toast('Success deleting data', 'success');
        // return redirect('/types')->with('status', 'Success Deleting Data!');
        return redirect('/types');
    }
}

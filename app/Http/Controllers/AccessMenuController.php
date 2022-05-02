<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Access_menu;
use App\Models\Menu;
use App\Models\Menu_header;
use App\Models\Role;
use Illuminate\Http\Request;

class AccessMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Role::all();
        $menuheader = Menu_header::with('menu')->get();
        $accessMenu = null;
        return view('menus.v_index',compact('role','menuheader','accessMenu'));
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
    public function show(Request $request,$id)
    {
        // dd($request->urlname);
        if ($request->urlname == 'access_menu') {
            $getAccessMenu = Access_menu::where('role_id',$id)->where('active',1)->get();

            return response()->json([
                'accessMenu' => $getAccessMenu,
                'role' => $id,
            ]);
        }
        if ($request->urlname == 'checked_menu') {
            // dd($request->all());
            if ($request->access_menu_id != null) {
                Access_menu::where('id',$request->access_menu_id)->update([
                    'active' => $request->active,
                ]);
            }else{
                Access_menu::create([
                    'menu_id' => $request->menu_id,
                    'role_id' => $request->role_id,
                    'active' => $request->active,
                ]);
            }

            if ($request->active == 1) {
                $alertTitle = $request->name .' Added';
                $icon = 'success';
            }else{
                $alertTitle = $request->name .' Deleted';
                $icon = 'error';
            }

            $getAccessMenu = Access_menu::where('role_id',$request->role_id)->where('active',1)->get();
            return response()->json([
                'accessMenu' => $getAccessMenu,
                'role' => $request->role_id,
                'alerttitle' => $alertTitle,
                'icon' => $icon
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

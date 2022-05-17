<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('authapi');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

     return view('master-clients.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('master-clients');
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
        $userid = session()->get('token')['user']['id'];
        $request->merge([
            'created_by' => $userid,
        ]);
          $request->validate([
          'name' => 'required',
         ]);
        Client::create($request->all());
        Alert::toast('Data Berhasil Ditambahkan, Silakan tambahkan contract !!!', 'success');
        return redirect('/contractProjects');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}

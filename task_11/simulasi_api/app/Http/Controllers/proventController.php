<?php

namespace App\Http\Controllers;

use App\Provent;
use Illuminate\Http\Request;

class proventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Provent::all();
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
        $request->validate([
            'gambar' => 'required'
        ]);
        $create = Provent::create(['gambar' => $request->gambar,'id_admin' => '1']);
        return [$create,'status' => 'success'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Provent  $provent
     * @return \Illuminate\Http\Response
     */
    public function show(Provent $provent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Provent  $provent
     * @return \Illuminate\Http\Response
     */
    public function edit(Provent $provent)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Provent  $provent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Provent $provent)
    {
        $request->validate([
            'gambar' => 'required'
        ]);
        $provent = Provent::find($provent->id);
        $provent->gambar = $request->gambar;
        $provent->save();

        return [$provent,'status' => 'success'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provent  $provent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provent $provent)
    {
        Provent::destroy($provent->id);
        return ['status' => 'success'];
    }
}

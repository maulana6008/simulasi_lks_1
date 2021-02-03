<?php

namespace App\Http\Controllers;

use App\Jenisbensin;
use Illuminate\Http\Request;

class bensinAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Jenisbensin::all();
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
            'jenis' => 'required',
            'harga' => 'required'
        ]);
        $create = JenisBensin::create([
            'jenis' => $request->jenis,
            'harga' => $request->harga
        ]);
        return [$create,'status' => 'success'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Jenisbensin  $jenisbensin
     * @return \Illuminate\Http\Response
     */
    public function show(Jenisbensin $jenisbensin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Jenisbensin  $jenisbensin
     * @return \Illuminate\Http\Response
     */
    public function edit(Jenisbensin $jenisbensin)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Jenisbensin  $jenisbensin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jenisbensin $jenisbensin)
    {
        $request->validate([
            'jenis' => 'required',
            'harga' => 'required'
        ]);
        $bensin = Jenisbensin::find($jenisbensin->id);
        $bensin->jenis = $request->jenis;
        $bensin->harga = $request->harga;
        $bensin->save();
        return [$bensin,'status' => 'success'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jenisbensin  $jenisbensin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jenisbensin $jenisbensin)
    {
        Jenisbensin::destroy($jenisbensin->id);
        return ['status' => 'success'];
    }
}

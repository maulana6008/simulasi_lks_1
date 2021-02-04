<?php

namespace App\Http\Controllers;

use App\Jenisbensin;
use Illuminate\Http\Request;

class bensinAdminController extends Controller
{

    public function cekUser(){
        $user = Auth::user();
        $level = Level::where('id_user',"$user->id")->get();
        return $level->level;
    }

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
        if (cekUser() == 'admin') {
            $request->validate([
                'jenis' => 'required',
                'harga' => 'required'
            ]);
            $create = JenisBensin::create([
                'jenis' => $request->jenis,
                'harga' => $request->harga
            ]);
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'gagal','error' => 'Anda tidak memiliki akses']);
        }
        
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
        if (cekUser == 'admin') {
            $request->validate([
                'jenis' => 'required',
                'harga' => 'required'
            ]);
            $bensin = Jenisbensin::find($jenisbensin->id);
            $bensin->jenis = $request->jenis;
            $bensin->harga = $request->harga;
            $bensin->save();
            return response()->json([$bensin,'status' => 'success']);
        }else{
            return response()->json(['status' => 'gagal','error' => 'Anda tidak memiliki akses']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jenisbensin  $jenisbensin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jenisbensin $jenisbensin)
    {
        if (cekUser() == 'admin') {
            Jenisbensin::destroy($jenisbensin->id);
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'gagal','error' => 'Anda tidak memiliki akses']);
        }
    }
}

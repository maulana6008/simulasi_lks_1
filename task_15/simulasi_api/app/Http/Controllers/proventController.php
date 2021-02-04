<?php

namespace App\Http\Controllers;

use App\Provent;
use Illuminate\Http\Request;

class proventController extends Controller
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
        if(cekUser() =='admin'){
            $request->validate([
                'gambar' => 'required'
            ]);
            $create = Provent::create(['gambar' => $request->gambar,'id_admin' => '1']);
            return response()->json([$create, 'status' => 'success']);
        }else{
            return response()->json(['status' => 'gagal','error' => 'Anda tidak memiliki akses']);
        }
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
        if(cekUser() =='admin'){
            $request->validate([
                'gambar' => 'required'
            ]);
            $provent = Provent::find($provent->id);
            $provent->gambar = $request->gambar;
            $provent->save();

            return response()->json([$provent, 'status' => 'success']);
        }else{
            return response()->json(['status' => 'gagal','error' => 'Anda tidak memiliki akses']);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provent  $provent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provent $provent)
    {
        if(cekUser() =='admin'){
            Provent::destroy($provent->id);
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'gagal','error' => 'Anda tidak memiliki akses']);
        }
        
    }
}

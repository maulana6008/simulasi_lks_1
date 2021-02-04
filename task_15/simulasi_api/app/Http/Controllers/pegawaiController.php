<?php

namespace App\Http\Controllers;

use App\Pegawai;
use App\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class pegawaiController extends Controller
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
        return Pegawai::all();
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
                'name' => 'required',
                'email' => 'required',
                'username' => 'required',
                'password' => 'required',
                'foto_profil' => 'required'
            ]);
            $create = Pegawai::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'foto_profil' => $request->foto_profil
            ]);
            Level::create([
                'level' => 'pegawai',
                'id_user' => $create->id
            ]);
            return response()->json([$create, 'status' => 'success']);
        }else{
            return response()->json(['status' => 'gagal','error' => 'Anda tidak memiliki akses']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function show(Pegawai $pegawai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function edit(Pegawai $pegawai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        if(cekUser() == 'admin'){
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'username' => 'required',
                'password' => 'required',
                'foto_profil' => 'required'
            ]);
            $pegawai = Pegawai::find($pegawai->id);
            $pegawai->name = $request->name;
            $pegawai->email = $request->email;
            $pegawai->username = $request->username;
            $pegawai->password = bcrypt($request->password);
            $pegawai->foto_profil = $request->foto_profil;
            $pegawai->save();

            return response()->json([$pegawai, 'status' => 'success']);
        }else{
            return response()->json(['status' => 'gagal','error' => 'Anda tidak memiliki akses']);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pegawai $pegawai)
    {
        if(cekUser() == 'admin'){
            Pegawai::destroy($pegawai->id);
            $level = Level::where('id_user',"$pegawai->id")->first();
            Level::destroy($level->id);
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'gagal','error' => 'Anda tidak memiliki akses']);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Bensin;
use App\Jenisbensin;
use App\User;
use App\Balance;
use App\Aktifitas;
use App\Provent;
use App\Level;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class mainController extends Controller
{

    public function cekUser(){
        $user = Auth::user();
        $level = Level::where('id_user',"$user->id")->get();
        return $level->level;
    }

    public function scanQR(Request $request, Bensin $bensin){
        if (cekUser() == 'pegawai') {
            $request->validate([
                'liter' => 'required'
            ]);
            $jml = Bensin::find($bensin->id);
            $liter = $jml->liter - $request->liter;

            $bensin = Bensin::find($bensin->id);
            $bensin->liter = $liter;
            $bensin->save();

            $harga = Jenisbensin::where('jenis',"$bensin->jenis")->first();
            $harga = $harga->harga * $request->liter;

            $user = User::find($bensin->id_customer);
            $credentials = Auth::user();
            Aktifitas::create([
                'status' => 'Pembelian '.$bensin->jenis,
                'harga' => $harga,
                'id_customer' => $user->id,
                'id_pegawai' => $credentials->id
            ]);
            return response()->json([
                'jenis' => $bensin->jenis,
                'liter' => $request->liter,
                'nama' => $user->name,
                'status' => 'success'
            ]); 
        }else{
            return response()->json(['status' => 'gagal','error' => 'Anda tidak memiliki akses']);
        }
        

    }

    public function daftarCustomer(Request $request){

    	$request->validate([
    		'name' => 'required',
    		'email' => 'required',
    		'username' => 'required',
    		'password' => 'required'
    	]);

    	$create = User::create([
    		'name' => $request->name,
    		'email' => $request->email,
    		'username' => $request->username,
    		'password' => bcrypt($request->password),
    		'foto_profil' => 'default'
    	]);
    	Level::create([
            'level' => 'customer',
            'id_user' => $create->id
        ]);
        Balance::create([
        	'id_customer' => $create->id,
        	'customer_balance' => '0'
        ]);
    	return response()->json([$create,'status' => 'success']);

    }

    public function editPengguna(Request $request,User $user){
    	$request->validate([
    		'name' => 'required',
    		'email' => 'required',
    		'username' => 'required',
    		'password' => 'required'
    	]);

    	$user = User::find($user->id);
    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->username = $request->username;
    	$user->password = bcrypt($request->password);
    	$user->save();

    	return response()->json([$user,'status' => 'success']);
    }

    public function beliBensin(Request $request,User $user){
        if (cekUser() == 'customer') {

            $request->validate([
                'jenis' => 'required',
                'liter' => 'required'
            ]);
            $harga = Jenisbensin::where('jenis',"$request->jenis")->first();
            $harga = $harga->harga * $request->liter;
            $balance = Balance::where('id_customer',"$user->id")->first();
            if ($balance->harga < $harga) {
                return ['status' => 'kurang'];
            }else{

                if (Bensin::where('id_customer',"$user->id")->where('jenis',"$request->jenis")->first() == null) {
                    Bensin::create([
                        'id_customer' => $user->id,
                        'jenis' => $request->jenis,
                        'liter' => $request->liter
                    ]);
                    Aktifitas::create([
                        'status' => 'Pembelian '.$request->jenis,
                        'harga' => $harga,
                        'id_customer' => $user->id,
                        'id_pegawai' => '0'
                    ]);
                    return ['status' => 'success'];
                }else{
                    $bensin = Bensin::where('id_customer',"$user->id")->first();
                    $bensin = Bensin::find($bensin->id);
                    $bensin->liter = $besin->liter + $request->liter;
                    $bensin->save();
                    Aktifitas::create([
                        'status' => 'Pembelian '.$request->jenis,
                        'harga' => $harga,
                        'id_customer' => $user->id,
                        'id_pegawai' => '0'
                    ]);
                    return response()->json(['status' => 'success']);
                }

            }

        }else{
            return response()->json(['status' => 'gagal','error' => 'Anda tidak memiliki akses']);
        }
    	

    }

    public function topUp(Request $request, User $user){
        $request->validate([
            'metode' => 'required',
            'total' => 'required',
            'invoice' => 'require',
            'status' => 'require'
        ]);
        Transaction::create([
            'id_customer' => $user->id,
            'total' => $request->total,
            'status' => 'pending',
            'metode' => $request->metode,
            'invoice' => $request->invoice
        ]);
        Aktifitas::create([
            'status' => 'Top Up',
            'harga' => $harga,
            'id_customer' => $user->id,
            'id_pegawai' => '0'
        ]);
        return response()->json(['status' => 'success']);
    }

    public function cekTopUp(User $user){
        // return Auth::user();
    }


    public function aktifitasTransaksi(){
        if (cekUser() == 'admin') {
            return Aktifitas::all();
        }else{
            return response()->json(['status' => 'gagal','error' => 'Anda tidak memiliki akses']);
        }
    }

    public function aktifitasCustomer(Aktifitas $aktifitas){
        if (cekUser() == 'customer') {
            return Aktifitas::where('id_customer',"$aktifitas->id")->get();
        }else{
            return response()->json(['status' => 'gagal','error' => 'Anda tidak memiliki akses']);
        }
        
    }

    public function aktifitasPegawai(Aktifitas $aktifitas){
        if (cekUser() == 'pegawai') {
            return Aktifitas::where('id_pegawai',"$aktifitas->id")->get();
        }else{
            return response()->json(['status' => 'gagal','error' => 'Anda tidak memiliki akses']);
        }
    }

    public function user(){
        return Auth::user();
    }

    public function saldo(User $user){
        if (cekUser() == 'customer') {
            return Balance::all();
        }else{
            return response()->json(['status' => 'gagal','error' => 'Anda tidak memiliki akses']);
        }
        
    }

    public function promo(){
        return Provent::where('jenis','promo')->get();
    }

    public function event(){
        return Provent::where('jenis','event')->get();
    }

    public function transaksiCustomer(User $user){
        if (cekUser() == 'customer') {
            return Transaction::where('id_customer',"$user->id")->get();
        }else{

            return response()->json(['status' => 'gagal','error' => 'Anda tidak memiliki akses']);
            
        }
    }

    public function qrcode(Jenisbensin $jenisbensin){
        
        if (cekUser() == 'customer') {
            $user = Auth::user();
            $user_bensin = Bensin::where('id_customer',"$user->id")->where('jenis',"$jenisbensin->jenis")->get();
            if ($user_bensin == null) {
                Bensin::create([
                    'id_customer' => $user->id,
                    'jenis' => $request->jenis,
                    'liter' => '0'
                ]);
                return response()->json(['status' => 'gagal', 'alert' => 'Bensin anda kosong']);
            }else{
                if ($user_bensin->liter < 1) {
                    return response()->json(['status' => 'gagal', 'alert' => 'Bensin anda kurang dari 1']);
                }else{
                    return response()->json(['status' => 'success']);
                }
            }
            

        }else{
            return response()->json(['status' => 'gagal','error' => 'Anda tidak memiliki akses']);
        }
    }


}

<?php

namespace App\Http\Controllers;

use App\Bensin;
use App\Jenisbensin;
use App\User;
use App\Balance;
use App\Aktifitas;
use Illuminate\Http\Request;

class mainController extends Controller
{
    public function scanQR(Bensin $bensin){
    	return Bensin::find($bensin->id);
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
    		'password' => $request->password,
    		'foto_profil' => 'default'
    	]);
    	Level::create([
            'level' => 'pegawai',
            'id_user' => $create->id
        ]);
        Balance::create([
        	'id_customer' => $create->id,
        	'customer_balance' => '0'
        ]);
    	return [$create,'status' => 'success'];

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
    	$user->password = $request->password;
    	$user->save();

    	return [$user,'success' => 'success'];
    }

    public function beliBensin(Request $request,User $user){
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
    				'id_customer' => $user->id
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
    				'id_customer' => $user->id
    			]);
    			return ['status' => 'success'];
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
    			'id_customer' => $user->id
    		]);
    	}

    	public function cekTopUp(User $user){
    		
    	}


    }



}

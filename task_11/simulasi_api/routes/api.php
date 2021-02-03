<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Pegawai
Route::get('/pegawai', 'pegawaiController@index');
Route::post('/pegawai', 'pegawaiController@store');
Route::put('/pegawai/{pegawai}', 'pegawaiController@update');
Route::delete('/pegawai/{pegawai}', 'pegawaiController@destroy');

// Jenis Bensin
Route::get('/jenisbensin', 'bensinAdminController@index');
Route::post('/jenisbensin', 'bensinAdminController@store');
Route::put('/jenisbensin/{jenisbensin}', 'bensinAdminController@update');
Route::delete('/jenisbensin/{jenisbensin}', 'bensinAdminController@destroy');

// Promo/Event
Route::get('/provent', 'proventController@index');
Route::post('/provent', 'proventController@store');
Route::put('/provent/{provent}', 'proventController@update');
Route::delete('/provent/{provent}', 'proventController@destroy');

// Pegawai Scan QR Customer
Route::get('/scan/{bensin}', 'mainController@scanQR');

// Pendaftaran Customer
Route::post('/daftar', 'mainController@daftarCustomer');

// Edit Profil Pengguna
Route::put('/edit/{user}', 'mainController@editPengguna');

// Beli Bensin
Route::post('/beli/{user}', 'mainController@beliBensin');

// Top Up 
Route::post('/topup/{user}', 'mainController@topUp');
Route::get('/topup/cek/{user}', 'mainController@cekTopUp');
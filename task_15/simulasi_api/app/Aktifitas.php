<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aktifitas extends Model
{
    protected $table = 'aktifitas';
    protected $fillable = ['id_customer','status','harga','id_pegawai'];
}

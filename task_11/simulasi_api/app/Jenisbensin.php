<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jenisbensin extends Model
{
    protected $table = 'jenis_bensin';
    protected $fillable = ['jenis','harga'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bensin extends Model
{
    protected $table = 'bensin';
    protected $fillable = ['id_customer','liter','jenis'];
}

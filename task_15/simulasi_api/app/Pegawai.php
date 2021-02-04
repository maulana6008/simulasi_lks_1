<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'users';
    protected $fillable = ['name','email','username','password','foto_profil'];
}

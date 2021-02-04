<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provent extends Model
{
    protected $table = 'promo_or_events';
    protected $fillable = ['id_admin','gambar'];
}

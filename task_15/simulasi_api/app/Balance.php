<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table = 'balance';
    protected $fillable = ['id_customer','customer_balance'];
}

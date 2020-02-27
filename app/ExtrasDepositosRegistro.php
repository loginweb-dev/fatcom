<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtrasDepositosRegistro extends Model
{
    protected $fillable = ['extra_deposito_id','cantidad','precio','user_id'];
}

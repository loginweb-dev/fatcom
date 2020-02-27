<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsumosDepositosRegistro extends Model
{
    protected $fillable = ['insumo_deposito_id','cantidad','precio','user_id'];
}

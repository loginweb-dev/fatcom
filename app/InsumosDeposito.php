<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsumosDeposito extends Model
{
    protected $fillable = ['deposito_id','insumo_id','stock'];
}

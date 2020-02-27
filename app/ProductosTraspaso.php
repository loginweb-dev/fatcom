<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductosTraspaso extends Model
{
    protected $fillable = ['user_id', 'deposito_id', 'deposito_id_receptor', 'observacion'];
}

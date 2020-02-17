<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposito extends Model
{
    protected $fillable = ['nombre', 'direccion', 'sucursal_id', 'inventario'];
}

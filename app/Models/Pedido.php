<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $with = ['detalle','cliente'];

    public function cliente() {
      return $this->belongsTo(\App\Cliente::class);
    }

    public function detalle(){
        return $this->hasMany(DetallePedido::class);
    }
}

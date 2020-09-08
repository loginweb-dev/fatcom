<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    protected $fillable = [
        'pedido_id','producto_id','precio','cantidad','observacion'
    ];
}

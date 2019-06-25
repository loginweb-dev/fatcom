<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class RepartidoresPedido extends Model
{
    protected $fillable = ['repartidor_id', 'pedido_id', 'estado'];
}

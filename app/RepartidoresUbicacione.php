<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class RepartidoresUbicacione extends Model
{
    protected $fillable = ['repartidor_pedido_id', 'lat', 'lon'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VentasDetallesExtra extends Model
{
    protected $fillable = ['venta_detalle_id', 'extra_id', 'precio', 'cantidad'];
}

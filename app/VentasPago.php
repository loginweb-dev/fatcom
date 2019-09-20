<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class VentasPago extends Model
{
    protected $fillable = ['venta_id', 'monto', 'observacion', 'user_id'];
}

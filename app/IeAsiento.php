<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IeAsiento extends Model
{
    protected $fillable = ['concepto', 'monto', 'tipo', 'fecha', 'hora', 'user_id', 'caja_id', 'venta_id', 'compra_id'];
}

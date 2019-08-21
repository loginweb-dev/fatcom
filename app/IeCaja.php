<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IeCaja extends Model
{
    protected $fillable = ['sucursal_id', 'nombre', 'observaciones', 'fecha_apertura', 'hora_apertura', 'fecha_cierre', 'hora_cierre', 'monto_inicial', 'monto_final', 'monto_real', 'monto_faltante', 'total_ingresos', 'total_egresos', 'abierta', 'user_id'];
}

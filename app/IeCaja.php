<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IeCaja extends Model
{
    protected $fillable = ['nombre', 'observaciones', 'fecha_apertura', 'hora_apertura', 'fecha_cierre', 'hora_cierre', 'monto_inicial', 'monto_final', 'total_ingresos', 'total_egresos', 'abierta', 'user_id'];
}

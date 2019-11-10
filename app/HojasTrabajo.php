<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class HojasTrabajo extends Model
{
    protected $fillable = ['sucursal_id', 'codigo', 'empleado_id', 'estado', 'observaciones'];
}

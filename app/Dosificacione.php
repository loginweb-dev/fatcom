<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dosificacione extends Model
{
    protected $fillable = ['nro_autorizacion', 'llave_dosificacion', 'fecha_limite', 'numero_inicial', 'numero_actual', 'activa'];
}

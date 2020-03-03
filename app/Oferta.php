<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Oferta extends Model
{
    protected $fillable = ['tipo_oferta', 'nombre', 'descripcion', 'tipo_duracion', 'dia', 'inicio'. 'fin', 'imagen', 'estado'];
}

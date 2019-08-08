<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Oferta extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'tipo_duracion', 'dia', 'inicio'. 'fin', 'imagen'];
}

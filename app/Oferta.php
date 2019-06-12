<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Oferta extends Model
{
    protected $fillable = ['nombre', 'detalle', 'inicio'. 'fin', 'imagen'];
}

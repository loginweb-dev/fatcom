<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursale extends Model
{
    protected $fillable = ['nombre', 'direccion', 'telefono', 'celular', 'latitud', 'longitud'];
}

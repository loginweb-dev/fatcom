<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['razon_social', 'nit', 'movil', 'direccion', 'ubicacion', 'descripcion'];
}

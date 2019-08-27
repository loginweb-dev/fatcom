<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ProductoUnidade extends Model
{
    protected $fillable = ['precio', 'precio_minimo', 'cantidad_pieza', 'cantidad_minima', 'unidad_id', 'producto_id'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ProductoUnidade extends Model
{
    protected $table = 'producto_unidades';
    protected $fillable = ['precio', 'precio_minimo', 'cantidad_unidad', 'cantidad_minima', 'unidad_id', 'producto_id'];
}

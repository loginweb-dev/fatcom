<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ProductosInsumo extends Model
{
    protected $fillable = ['producto_id', 'insumo_id', 'cantidad'];
}

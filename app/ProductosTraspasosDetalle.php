<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductosTraspasosDetalle extends Model
{
    protected $fillable = ['producto_traspaso_id', 'producto_id', 'cantidad'];
}

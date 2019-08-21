<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class EcommerceEnvio extends Model
{
    protected $fillable = ['ecommerce_producto_id', 'localidad_id', 'precio'];
}

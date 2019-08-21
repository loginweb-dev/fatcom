<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ProductosDeposito extends Model
{
    protected $fillable = ['deposito_id', 'producto_id', 'stock', 'stock_inicial', 'stock_compra'];
}

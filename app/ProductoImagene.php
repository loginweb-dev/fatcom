<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ProductoImagene extends Model
{
    protected $fillable = ['producto_id', 'imagen', 'tipo'];
}

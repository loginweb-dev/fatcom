<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ProductosLike extends Model
{
    protected $fillable = ['producto_id', 'user_id'];
}

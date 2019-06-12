<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Moneda extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    // protected $fillable = ['numero', 'tamanio_id'];
}

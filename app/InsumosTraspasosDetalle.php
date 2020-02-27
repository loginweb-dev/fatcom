<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsumosTraspasosDetalle extends Model
{
    protected $fillable = ['insumo_traspaso_id','insumo_id','cantidad'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsumosTraspaso extends Model
{
    protected $fillable = ['user_id','deposito_id','deposito_id_receptor','observacion'];
}

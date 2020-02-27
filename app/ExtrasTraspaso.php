<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtrasTraspaso extends Model
{
    protected $fillable = ['user_id','deposito_id','deposito_id_receptor','observacion'];
}

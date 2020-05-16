<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlockInput extends Model
{
    protected $table = 't_block_input';
    protected $fillable = ['t_block_id', 'type', 'value', 'order'];
}

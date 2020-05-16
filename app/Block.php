<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $table = 't_blocks';
    protected $fillable = ['t_section_id', 'order'];

    public function inputs(){
        return $this->hasMany('App\BlockInput', 't_block_id');
    }
}

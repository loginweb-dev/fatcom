<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 't_templates';
    protected $fillable = ['name', 'description'];

    public function sections(){
        return $this->hasMany('App\Section', 't_template_id');
    }
}

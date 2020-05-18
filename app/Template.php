<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 't_templates';
    protected $fillable = ['name', 'description'];

    public function pages(){
        return $this->hasMany('App\Page', 't_template_id');
    }
}

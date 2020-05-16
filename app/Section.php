<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 't_sections';
    protected $fillable = ['t_template_id', 'name', 'description', 'order'];

    public function blocks(){
        return $this->hasMany('App\Block', 't_section_id');
    }
}

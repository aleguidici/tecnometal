<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPersona extends Model
{
    protected $guarded = [];
    
    protected $table = 'tipos_persona';

    public function personas() {
        return $this->hasMany('App\Persona');
    }
}

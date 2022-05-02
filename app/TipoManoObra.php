<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoManoObra extends Model
{
    protected $guarded = [];
    
    protected $table = 'tipos_mano_obra';

    public function manos_obra() { 
        return $this->hasMany('App\ManoObra');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoPresupuesto extends Model
{
    protected $guarded = [];
    
    protected $table = 'estados_presupuestos';

    public function estados_presupuestos() { 
        return $this->hasMany('App\Presupuesto');
    }
}

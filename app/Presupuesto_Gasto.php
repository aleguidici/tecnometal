<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presupuesto_Gasto extends Model
{
    protected $guarded = [];

    protected $table = 'presupuesto_gastos';

    public function presupuesto() {
        return $this->belongsTo('App\Presupuesto');
    }
}

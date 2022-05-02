<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    protected $guarded = [];

    protected $fillable = ['id','fecha','vencimiento','referencia','obra','observaciones','persona_id', 'contacto_id','estado_presupuesto_id','moneda_material','moneda_mano_obra','user_id'];

    protected $table = 'presupuestos';

    public function persona() {
        return $this->belongsTo('App\Persona');
    }
    
    public function contacto() {
        return $this->belongsTo('App\Contacto');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function estado_presupuesto() {
        return $this->belongsTo('App\EstadoPresupuesto');
    }

    public function items() {
        return $this->hasMany('App\Item');
    }

    public function moneda_materiales(){
        return $this->belongsTo('App\Moneda','moneda_material');
    }

    public function presupuesto_gastos_preest() {
        return $this->hasMany('App\Presupuesto_Gasto');
    }

    public function moneda_manos_obra(){
        return $this->belongsTo('App\Moneda','moneda_mano_obra');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $guarded = [];

    protected $table = 'personas';

    protected $fillable  = ['name','direccion','cuil','ingresos_brutos', 'condicion_iva','localidad_id','tipo_persona_id','user_id'];

    // Define una relación entre la persona y su tipo de persona
    public function tipo_persona() {
        return $this->belongsTo('App\TipoPersona');
    }

    // Define una relación entre la persona y su localidad
    public function localidad() {
        return $this->belongsTo('App\Localidad');
    }

    public function presupuestos() {
        return $this->hasMany('App\Presupuesto');
    }

    public function contactos() {
        return $this->hasMany('App\Contacto');
    }

    public function items_materiales() {
        return $this->hasMany('App\Item_Material');
    }
}

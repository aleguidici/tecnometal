<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];

    protected $table = 'items';

    protected $fillable = ['id','descripcion','cantidad','descripcion_materiales','descipcion_manos_obra','presupuesto_id'];

    public function persona() {
        return $this->belongsTo('App\Persona');
    }

    public function presupuesto(){
        return $this->belongsTo('App\Presupuesto');
    }

    public function items_manos_obra() {
        return $this->hasMany('App\Item_ManoObra');
    }

    public function items_materiales() {
        return $this->hasMany('App\Item_Material');
    }

    public function AP_items() {
        return $this->hasMany('App\AP_Item');
    }

    public function gastos(){
        return $this->hasMany('App\Item_Gasto','item_id');
    }
}

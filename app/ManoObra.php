<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManoObra extends Model
{
    protected $guarded = [];

    protected $table = 'manos_obra';

    public function tipo_mano_obra() {
        return $this->belongsTo('App\TipoManoObra');
    }

    public function ap_manos_obra() {
        return $this->hasMany('App\AP_ManoObra');
    }

    public function items_manos_obra() {
        return $this->hasMany('App\Item_ManoObra');
    }
}

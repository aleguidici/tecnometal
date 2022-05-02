<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AP_ManoObra extends Model
{
    protected $guarded = [];

    protected $table = 'aps_manos_obra';

    public function mano_obra() {
        return $this->belongsTo('App\ManoObra');
    }

    public function actividad_preestablecida() {
        return $this->belongsTo('App\ActividadPreestablecida','ap_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActividadPreestablecida extends Model
{
    protected $guarded = [];

    protected $table = 'actividades_preestablecidas';

    public function AP_materiales() {
        return $this->hasMany('App\AP_Material','ap_id');
    }

    public function AP_manos_obra() {
        return $this->hasMany('App\AP_ManoObra','ap_id');
    }

    public function AP_items() {
        return $this->hasMany('App\AP_Item');
    }
}

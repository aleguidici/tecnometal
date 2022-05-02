<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AP_Material extends Model
{
    protected $guarded = [];

    protected $table = 'aps_materiales';

    public function material() {
        return $this->belongsTo('App\Material');
    }

    public function actividad_preestablecida() {
        return $this->belongsTo('App\ActividadPreestablecida','ap_id');
    }
}

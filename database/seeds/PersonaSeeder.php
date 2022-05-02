<?php

use App\Persona;
use App\TipoPersona;
use App\Localidad;
use App\Provincia;
use App\User;
use Illuminate\Database\Seeder;

class PersonaSeeder extends Seeder
{
    public function run()
    {
        $id_TipoPersona = TipoPersona::where('name','Proveedor')->value('id');
        $id_localidad = Localidad::where('name','Posadas')->value('id');
        $id_user = User::where('id',1)->value('id');

        Persona::create([
            'name'=>'Ejemplo Proveedor',
            'direccion' => 'San Jose 2051',
            'cuil' => '25-588558-65',
            'ingresos_brutos' => 1,
            'condicion_iva' => 'Monotributista',
            'localidad_id' => $id_localidad,
            'tipo_persona_id' => $id_TipoPersona,
            'user_id' => $id_user
        ]);

        $id_TipoPersona = TipoPersona::where('name','Cliente')->value('id');
        $id_localidad = Localidad::where('name','Posadas')->value('id');

        Persona::create([
            'name'=>'Ejemplo Cliente',
            'direccion' => 'Bolivar 2661',
            'cuil' => '25-15151515-65',
            'ingresos_brutos' => 0,
            'condicion_iva' => 'IVA Responsable inscripto',
            'localidad_id' => $id_localidad,
            'tipo_persona_id' => $id_TipoPersona,
            'user_id' => $id_user
        ]);
    }
}

<?php

use App\Persona;
use App\EstadoPresupuesto;
use App\Presupuesto;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Moneda;

class PresupuestoSeeder extends Seeder
{
    public function run()
    {
        $id_persona = Persona::where('id',2)->value('id');
        $id_estado = EstadoPresupuesto::where('id',1)->value('id');
        $id_moneda_dolar = Moneda::where('id',2)->value('id');
        $id_moneda_peso = Moneda::where('id',1)->value('id');
        Presupuesto::create([
            'id'=>'2000001',
            'fecha'=>Carbon::parse('2020-08-10'),
            'vencimiento'=>Carbon::parse('2020-12-16'),
            'referencia' =>'ACT. 177/20 REPARACION DE PUERTA',
            'obra' =>'EBAP 149',
            'observaciones' =>'Presupuesto numero 1 para el Cliente',
            'persona_id' => $id_persona,
            'moneda_material' => $id_moneda_dolar,
            'moneda_mano_obra'=> $id_moneda_peso,
            'estado_presupuesto_id' => $id_estado
        ]);

        $id_estado = EstadoPresupuesto::where('id',5)->value('id');

        Presupuesto::create([
            'id'=>'2000002',
            'fecha'=>Carbon::parse('2020-06-22'),
            'vencimiento'=>Carbon::parse('2020-08-28'),
            'referencia' =>'NODE INGRESO A CAMARA DE REJAS - RED DE IMPULSION DE DESAGÜES CLOACALES',
            'obra' =>'INMET - PUERTO IGUAZÚ',
            'observaciones' =>'Presupuesto numero 2 para el Cliente',
            'persona_id' => $id_persona,
            'moneda_material' => $id_moneda_dolar,
            'moneda_mano_obra'=> $id_moneda_peso,
            'estado_presupuesto_id' => $id_estado
        ]);
    }
}

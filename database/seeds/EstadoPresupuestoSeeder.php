<?php

use App\EstadoPresupuesto;
use Illuminate\Database\Seeder;

class EstadoPresupuestoSeeder extends Seeder
{
    public function run()
    {
        EstadoPresupuesto::create([
            'descripcion'=>'Activo'
        ]);

        EstadoPresupuesto::create([
            'descripcion'=>'Vencido'
        ]);

        EstadoPresupuesto::create([
            'descripcion'=>'Aprobado'
        ]);


        EstadoPresupuesto::create([
            'descripcion'=>'Anulado'
        ]);

        EstadoPresupuesto::create([
            'descripcion'=>'Borrador'
        ]);
    }
}

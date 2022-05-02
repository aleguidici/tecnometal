<?php

use App\GastoPreest;
use Illuminate\Database\Seeder;

class Gastos_PreestSeeder extends Seeder
{
    public function run()
    {
        $gastos = [
            ['descripcion'=>'Per. Ingresos Brutos', 'valor' => 0.0331],
            ['descripcion'=>'Per. Municipal', 'valor' => 0.008],
            ['descripcion'=>'Gastos Generales', 'valor' => 0.1],
            ['descripcion'=>'Beneficio', 'valor' => 0.3],
            ['descripcion'=>'Impuesto a la Ganancia', 'valor' => 0.35],
            ['descripcion'=>'Impuesto al cheque', 'valor' => 0.012],
            ['descripcion'=>'I.V.A.', 'valor' => 0.21],
        ];

        foreach ($gastos as $gasto) {
            GastoPreest::create($gasto);
        }
    }
}

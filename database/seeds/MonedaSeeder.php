<?php

use App\Moneda;
use Illuminate\Database\Seeder;

class MonedaSeeder extends Seeder
{
    public function run()
    {
        $monedas = [
            ['descripcion'=>'Pesos argentinos', 'signo' => '$'],
            ['descripcion'=>'Dólares estadounidenses', 'signo' => 'U$D'],
            ['descripcion'=>'Reales', 'signo' => 'R$'],
            ['descripcion'=>'Guaraníes', 'signo' => 'Gs.']
        ];

        foreach ($monedas as $moneda) {
            Moneda::create($moneda);
        }
    }
}

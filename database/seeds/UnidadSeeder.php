<?php

use App\Unidad;
use Illuminate\Database\Seeder;

class UnidadSeeder extends Seeder
{
    public function run()
    {
        $unidades = [
            ['descripcion'=>'Cajas / Paquetes'],
            ['descripcion'=>'Centímetros'],
            ['descripcion'=>'Centímetros cuadrados'],
            ['descripcion'=>'Centímetros cúbicos'],
            ['descripcion'=>'Docenas'],
            ['descripcion'=>'Gramos'],
            ['descripcion'=>'Kilogramos'],
            ['descripcion'=>'Litros'],
            ['descripcion'=>'Metros'],
            ['descripcion'=>'Metros cuadrados'],
            ['descripcion'=>'Metros cúbicos'],
            ['descripcion'=>'Miligramos'],
            ['descripcion'=>'Milímetros'],
            ['descripcion'=>'Milímetros cuadrados'],
            ['descripcion'=>'Milímetros cúbicos'],
            ['descripcion'=>'Pares'],
            ['descripcion'=>'Toneladas'],
            ['descripcion'=>'Unidades'],
            ['descripcion'=>'Pulgadas'],
            ['descripcion'=>'Horas'],
            ['descripcion'=>'Minutos'],
            ['descripcion'=>'Segundos']    
       ];

        foreach ($unidades as $unidad) {
            Unidad::create($unidad);
        }
    }
}

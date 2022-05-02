<?php

use App\TipoManoObra;
use Illuminate\Database\Seeder;

class TipoManoObraSeeder extends Seeder
{
    public function run()
    {
        $tipos = [
            ['descripcion'=>'Fabricación'],
            ['descripcion'=>'Instalación'],
            ['descripcion'=>'Mantenimiento']
        ];

        foreach ($tipos as $tiposManoObra) {
            TipoManoObra::create($tiposManoObra);
        }
    }
}

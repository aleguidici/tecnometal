<?php

use App\ManoObra;
use App\TipoManoObra;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ManoObraSeeder extends Seeder
{
    public function run()
    {
        $id_TipoManoObra = TipoManoObra::where('descripcion','Fabricacion')->value('id');

        ManoObra::create([
            'name'=>'Soldadura de acero común / inoxidable',
            'descripcion'=>'Soldadura de acero común / inoxidable para Bridas y para Caño c/ Caño.',
            'tipo_mano_obra_id' => $id_TipoManoObra,
        ]);
    }
}

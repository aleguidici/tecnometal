<?php

use App\Contacto;
use App\Persona;
use Illuminate\Database\Seeder;

class ContactoSeeder extends Seeder
{
    public function run()
    {
        $id_persona = Persona::where('id',1)->value('id');

        Contacto::create([
            'name'=> 'Contacto 1',
            'telefono'=> '0376-4564564',
            'email' => 'proveedor_contacto1@gmail.com',
            'persona_id' => $id_persona
        ]);

        Contacto::create([
            'name'=> 'Contacto 2',
            'telefono'=> '0376-4564334',
            'email' => 'proveedor_contacto2@gmail.com',
            'persona_id' => $id_persona
        ]);

        $id_persona = Persona::where('id',2)->value('id');

        Contacto::create([
            'name'=> 'Contacto 1',
            'telefono'=> '0376-4524564',
            'email' => 'cliente_contacto1@gmail.com',
            'persona_id' => $id_persona
        ]);

        Contacto::create([
            'name'=> 'Contacto 2',
            'telefono'=> '0376-4154334',
            'email' => 'cliente_contacto2@gmail.com',
            'persona_id' => $id_persona
        ]);
    }
}

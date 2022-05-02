<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // No borrar. Valores por defecto
        $this->call(PaisSeeder::class);
        $this->call(ProvinciaSeeder::class);
        $this->call(LocalidadSeeder::class);
        $this->call(TipoPersonaSeeder::class);
        $this->call(EstadoPresupuestoSeeder::class);
        $this->call(TipoManoObraSeeder::class);
        $this->call(UnidadSeeder::class);
        $this->call(MonedaSeeder::class);
        $this->call(Gastos_PreestSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ActividadPreestSeeder::class);
        $this->call(ManoObraSeeder::class);
        $this->call(AP_ManoObraSeeder::class);
        $this->call(MaterialSeeder::class);
        $this->call(AP_MaterialSeeder::class);
        // No borrar. Valores por defecto

        // BORRAR al entregar el sistema
        $this->call(PersonaSeeder::class);
        //$this->call(PresupuestoSeeder::class);    
        //$this->call(ItemSeeder::class);
        //$this->call(Item_GastosSeeder::class);
        //$this->call(Item_ManoObraSeeder::class);
        //$this->call(Item_MaterialSeeder::class);
        $this->call(ContactoSeeder::class);
        //$this->call(AP_ItemSeeder::class);
        // BORRAR al entregar el sistema
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTable extends Migration
{
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('name'); //razón social
            $table->string('direccion');
            $table->string('cuil');
            $table->boolean('ingresos_brutos');
            $table->string('condicion_iva');
            $table->bigInteger('localidad_id')->unsigned();
            $table->bigInteger('tipo_persona_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();
            
            $table->unique(['cuil', 'tipo_persona_id']); //De un mismo cuil, puede existir solo UN CLIENTE Y UN PROVEEDOR
            $table->foreign('localidad_id')->references('id')->on('localidades')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('tipo_persona_id')->references('id')->on('tipos_persona')->onDelete('restrict')->onUpdate('cascade'); //Cliente o proveedor
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('persona');
    }
}

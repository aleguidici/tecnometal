<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsMaterialesTable extends Migration
{
    public function up()
    {
        Schema::create('items_materiales', function (Blueprint $table) {
            $table->id();
            $table->float('cantidad', 20, 2);
            $table->boolean('reventa');
            $table->float('precio_unitario', 20, 2);
            $table->string('marca', 100)->nullable();
            $table->string('codigo', 50)->nullable();
            $table->bigInteger('item_id')->unsigned();
            $table->bigInteger('material_id')->unsigned();
            $table->bigInteger('moneda_id')->unsigned();
            $table->float('iibb', 8, 4)->nullable();
            $table->float('gastos_generales', 8, 4)->nullable();
            $table->string('presupuesto_proveedor')->nullable();
            $table->bigInteger('persona_id')->nullable()->unsigned();
            $table->timestamps();

            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('material_id')->references('id')->on('materiales')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('moneda_id')->references('id')->on('monedas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('persona_id')->references('id')->on('personas')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('items_materiales');
    }
}

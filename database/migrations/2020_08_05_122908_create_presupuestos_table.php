<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresupuestosTable extends Migration
{
    public function up()
    {
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned();
            $table->date('fecha');
            $table->date('vencimiento');
            $table->string('referencia', 255)->nullable();
            $table->string('obra', 255)->nullable();
            $table->string('rechazado', 100)->nullable();
            $table->longText('observaciones')->nullable();
            $table->bigInteger('persona_id')->unsigned();
            $table->bigInteger('estado_presupuesto_id')->unsigned();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('moneda_material')->unsigned();
            $table->bigInteger('moneda_mano_obra')->unsigned();
            $table->boolean('tablas_unificadas')->default(false);
            $table->boolean('eliminado')->default(false);
            $table->timestamps();

            $table->primary('id');
            $table->foreign('persona_id')->references('id')->on('personas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('estado_presupuesto_id')->references('id')->on('estados_presupuestos')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('moneda_material')->references('id')->on('monedas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('moneda_mano_obra')->references('id')->on('monedas')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('presupuestos');
    }
}

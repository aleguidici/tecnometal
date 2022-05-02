<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresupuestosGastosTable extends Migration
{
    public function up()
    {
        Schema::create('presupuesto_gastos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('presupuesto_id')->unsigned();
            $table->string('descripcion');
            $table->float('monto',12,2)->nullable();
            $table->float('percentage',7,4)->nullable();
            $table->boolean('es_monto')->nullable();
            $table->timestamps();

            $table->foreign('presupuesto_id')->references('id')->on('presupuestos')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('presupuesto_gastos');
    }
}

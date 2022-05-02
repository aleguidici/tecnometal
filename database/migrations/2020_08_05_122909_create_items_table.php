<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->integer('cantidad');
            $table->text('descripcion_materiales')->nullable();
            $table->text('descipcion_manos_obra')->nullable();
            $table->float('flete',12,2)->nullable();
            $table->bigInteger('presupuesto_id')->unsigned();
            $table->timestamps();

            $table->foreign('presupuesto_id')->references('id')->on('presupuestos')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
}

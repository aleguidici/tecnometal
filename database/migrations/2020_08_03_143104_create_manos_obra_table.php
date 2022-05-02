<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManosObraTable extends Migration
{
    public function up()
    {
        Schema::create('manos_obra', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('descripcion', 255);
            $table->bigInteger('tipo_mano_obra_id')->unsigned();
            $table->timestamps();

            $table->foreign('tipo_mano_obra_id')->references('id')->on('tipos_mano_obra')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('manos_obra');
    }
}

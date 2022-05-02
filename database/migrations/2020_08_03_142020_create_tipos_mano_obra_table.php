<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiposManoObraTable extends Migration
{
    public function up()
    {
        Schema::create('tipos_mano_obra', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipos_mano_obra');
    }
}

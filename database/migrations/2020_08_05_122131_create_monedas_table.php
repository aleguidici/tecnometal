<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonedasTable extends Migration
{
    public function up()
    {
        Schema::create('monedas', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->string('signo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('monedas');
    }
}

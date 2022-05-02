<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGastosPreestTable extends Migration
{
    public function up()
    {
        Schema::create('gastos_preest', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->float('valor',8,4);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gastos_preest');
    }
}

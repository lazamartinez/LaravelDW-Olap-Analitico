<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dw.dim_tiempo', function (Blueprint $table) {
            $table->id('tiempo_id');
            $table->date('fecha')->unique();
            $table->integer('dia');
            $table->integer('mes');
            $table->integer('anio');
            $table->integer('trimestre');
            $table->integer('dia_semana');
            $table->string('nombre_dia', 10);
            $table->string('nombre_mes', 10);
            $table->boolean('es_fin_semana');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dw.dim_tiempo');
    }
};

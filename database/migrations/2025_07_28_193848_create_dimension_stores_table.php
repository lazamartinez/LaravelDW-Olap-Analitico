<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dw.dim_sucursal', function (Blueprint $table) {
            $table->id('sucursal_id');
            $table->string('codigo', 20)->unique();
            $table->string('nombre', 100);
            $table->string('provincia', 50);
            $table->string('canton', 50);
            $table->string('distrito', 50);
            $table->text('direccion_exacta')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->text('horario')->nullable();
            $table->date('fecha_apertura');
            $table->boolean('activa')->default(true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('dw.dim_sucursal');
    }
};

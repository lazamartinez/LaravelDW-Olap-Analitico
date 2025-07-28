<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dw.dim_cliente', function (Blueprint $table) {
            $table->id('cliente_id');
            $table->string('identificacion', 20)->unique();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('provincia', 50);
            $table->string('canton', 50)->nullable();
            $table->string('distrito', 50)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('segmento', 50)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dw.dim_cliente');
    }
};

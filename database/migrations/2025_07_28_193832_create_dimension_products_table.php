<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dw.dim_producto', function (Blueprint $table) {
            $table->id('producto_id');
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 100);
            $table->string('categoria', 50);
            $table->string('subcategoria', 50)->nullable();
            $table->decimal('precio_base', 10, 2);
            $table->decimal('costo', 10, 2);
        });
    }

    public function down()
    {
        Schema::dropIfExists('dw.dim_producto');
    }
};

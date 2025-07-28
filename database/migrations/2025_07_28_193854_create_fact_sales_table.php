<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dw.fact_ventas', function (Blueprint $table) {
            $table->id('venta_id');
            $table->foreignId('tiempo_id')->constrained('dw.dim_tiempo', 'tiempo_id');
            $table->foreignId('producto_id')->constrained('dw.dim_producto', 'producto_id');
            $table->foreignId('cliente_id')->constrained('dw.dim_cliente', 'cliente_id');
            $table->foreignId('sucursal_id')->constrained('dw.dim_sucursal', 'sucursal_id');
            $table->integer('cantidad_vendida');
            $table->decimal('monto_total', 12, 2);
            $table->decimal('descuento_total', 12, 2)->default(0);
            $table->decimal('costo_total', 12, 2);
            $table->decimal('margen_ganancia', 12, 2);
            $table->string('metodo_pago', 50);
        });
    }

    public function down()
    {
        Schema::dropIfExists('dw.fact_ventas');
    }
};

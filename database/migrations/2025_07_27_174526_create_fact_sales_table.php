<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactSalesTable extends Migration
{
    public function up()
    {
        Schema::create('dw.fact_sales', function (Blueprint $table) {
            $table->id('sales_id');
            $table->foreignId('time_id')->constrained('dw.dim_time', 'time_id');
            $table->foreignId('product_id')->constrained('dw.dim_product', 'product_id');
            $table->foreignId('customer_id')->constrained('dw.dim_customer', 'customer_id');
            $table->foreignId('store_id')->constrained('dw.dim_store', 'store_id');
            $table->integer('quantity_sold');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_amount', 12, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('net_amount', 12, 2);
            $table->timestamps();
            
            $table->index('time_id');
            $table->index('product_id');
            $table->index('customer_id');
            $table->index('store_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dw.fact_sales');
    }
}
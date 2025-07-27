<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDimProductTable extends Migration
{
    public function up()
    {
        Schema::create('dw.dim_product', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_code', 50)->unique();
            $table->string('name', 100);
            $table->string('category', 50);
            $table->decimal('price', 10, 2);
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index('category');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dw.dim_product');
    }
}
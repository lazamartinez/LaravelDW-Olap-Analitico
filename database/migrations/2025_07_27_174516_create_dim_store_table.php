<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDimStoreTable extends Migration
{
    public function up()
    {
        Schema::create('dw.dim_store', function (Blueprint $table) {
            $table->id('store_id');
            $table->string('code', 20)->unique();
            $table->string('name', 100);
            $table->string('address', 200);
            $table->string('city', 50);
            $table->string('province', 50);
            $table->string('postal_code', 10)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
            
            $table->index(['province', 'city']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('dw.dim_store');
    }
}
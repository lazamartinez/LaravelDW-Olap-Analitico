<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDimCustomerTable extends Migration
{
    public function up()
    {
        Schema::create('dw.dim_customer', function (Blueprint $table) {
            $table->id('customer_id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('city', 50);
            $table->string('province', 50);
            $table->string('postal_code', 10)->nullable();
            $table->timestamps();
            
            $table->index(['province', 'city']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('dw.dim_customer');
    }
}
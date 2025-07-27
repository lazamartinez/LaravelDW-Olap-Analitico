<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDimTimeTable extends Migration
{
    public function up()
    {
        Schema::create('dw.dim_time', function (Blueprint $table) {
            $table->id('time_id');
            $table->date('date');
            $table->integer('day');
            $table->integer('month');
            $table->integer('year');
            $table->integer('quarter');
            $table->integer('day_of_week');
            $table->string('day_name', 10);
            $table->string('month_name', 10);
            $table->boolean('is_weekend')->default(false);
            $table->timestamps();
            
            $table->index('date');
            $table->index(['year', 'month']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('dw.dim_time');
    }
}
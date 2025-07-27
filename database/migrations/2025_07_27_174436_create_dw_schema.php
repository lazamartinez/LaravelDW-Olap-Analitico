<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateDwSchema extends Migration
{
    public function up()
    {
        DB::statement('CREATE SCHEMA IF NOT EXISTS dw');
    }

    public function down()
    {
        DB::statement('DROP SCHEMA IF EXISTS dw CASCADE');
    }
}
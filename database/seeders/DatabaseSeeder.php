<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            DimensionTimeSeeder::class,
            DimensionProductSeeder::class,
            DimensionCustomerSeeder::class,
            DimensionStoreSeeder::class,
            FactSaleSeeder::class,
        ]);
    }
}

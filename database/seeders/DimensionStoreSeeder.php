<?php

namespace Database\Seeders;

use App\Models\DimensionStore;
use Illuminate\Database\Seeder;

class DimensionStoreSeeder extends Seeder
{
    public function run()
    {
        $stores = [
            ['code' => 'ST001', 'name' => 'Supermercado Centro', 'address' => 'Calle Mayor 10', 'city' => 'Madrid', 'province' => 'Madrid'],
            ['code' => 'ST002', 'name' => 'Supermercado Norte', 'address' => 'Avenida Diagonal 100', 'city' => 'Barcelona', 'province' => 'Barcelona'],
            ['code' => 'ST003', 'name' => 'Supermercado Este', 'address' => 'Calle Colón 50', 'city' => 'Valencia', 'province' => 'Valencia'],
            ['code' => 'ST004', 'name' => 'Supermercado Sur', 'address' => 'Calle Sierpes 20', 'city' => 'Sevilla', 'province' => 'Sevilla'],
        ];

        foreach ($stores as $store) {
            DimensionStore::create($store);
        }
    }
}
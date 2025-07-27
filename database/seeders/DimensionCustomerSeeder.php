<?php

namespace Database\Seeders;

use App\Models\DimensionCustomer;
use Illuminate\Database\Seeder;

class DimensionCustomerSeeder extends Seeder
{
    public function run()
    {
        $customers = [
            ['first_name' => 'Juan', 'last_name' => 'Pérez', 'city' => 'Madrid', 'province' => 'Madrid'],
            ['first_name' => 'María', 'last_name' => 'Gómez', 'city' => 'Barcelona', 'province' => 'Barcelona'],
            ['first_name' => 'Carlos', 'last_name' => 'López', 'city' => 'Valencia', 'province' => 'Valencia'],
            ['first_name' => 'Ana', 'last_name' => 'Martínez', 'city' => 'Sevilla', 'province' => 'Sevilla'],
            ['first_name' => 'Luis', 'last_name' => 'Rodríguez', 'city' => 'Zaragoza', 'province' => 'Zaragoza'],
        ];

        foreach ($customers as $customer) {
            DimensionCustomer::create($customer);
        }
    }
}
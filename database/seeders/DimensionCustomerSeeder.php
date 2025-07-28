<?php

namespace Database\Seeders;

use App\Models\DimensionCustomer;
use Illuminate\Database\Seeder;

class DimensionCustomerSeeder extends Seeder
{
    public function run()
    {
        $customers = [
            [
                'identificacion' => '101110111',
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'provincia' => 'San José',
                'canton' => 'Central',
                'distrito' => 'Carmen',
                'segmento' => 'Premium'
            ],
            [
                'identificacion' => '202220222',
                'nombre' => 'María',
                'apellido' => 'Gómez',
                'provincia' => 'Alajuela',
                'canton' => 'Central',
                'distrito' => 'San Rafael',
                'segmento' => 'Regular'
            ]
        ];

        foreach ($customers as $customer) {
            DimensionCustomer::create($customer);
        }
    }
}

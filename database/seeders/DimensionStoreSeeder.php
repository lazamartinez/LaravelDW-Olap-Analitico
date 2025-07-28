<?php

namespace Database\Seeders;

use App\Models\DimensionStore;
use Illuminate\Database\Seeder;

class DimensionStoreSeeder extends Seeder
{
    public function run()
    {
        $stores = [
            [
                'codigo' => 'SUC001',
                'nombre' => 'Sucursal Central',
                'provincia' => 'San José',
                'canton' => 'Central',
                'distrito' => 'Carmen',
                'direccion_exacta' => 'Avenida Central, Calle 5',
                'telefono' => '22222222',
                'fecha_apertura' => '2020-01-15',
                'activa' => true
            ],
            [
                'codigo' => 'SUC002',
                'nombre' => 'Sucursal Oeste',
                'provincia' => 'San José',
                'canton' => 'Escazú',
                'distrito' => 'San Rafael',
                'direccion_exacta' => 'Calle Blancos, 200m oeste del mall',
                'telefono' => '22332233',
                'fecha_apertura' => '2021-03-10',
                'activa' => true
            ]
        ];

        foreach ($stores as $store) {
            DimensionStore::create($store);
        }
    }
}

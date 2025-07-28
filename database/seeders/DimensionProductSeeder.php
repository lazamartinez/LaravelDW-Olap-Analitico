<?php

namespace Database\Seeders;

use App\Models\DimensionProduct;
use Illuminate\Database\Seeder;

class DimensionProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'codigo' => 'PROD001',
                'nombre' => 'Arroz 1kg',
                'categoria' => 'Granos',
                'precio_base' => 1.20,
                'costo' => 0.80
            ],
            [
                'codigo' => 'PROD002',
                'nombre' => 'Leche 1L',
                'categoria' => 'Lácteos',
                'precio_base' => 1.50,
                'costo' => 1.00
            ],
            [
                'codigo' => 'PROD003',
                'nombre' => 'Pan Integral',
                'categoria' => 'Panadería',
                'precio_base' => 0.80,
                'costo' => 0.40
            ],
            [
                'codigo' => 'PROD004',
                'nombre' => 'Manzanas 1kg',
                'categoria' => 'Frutas',
                'precio_base' => 2.50,
                'costo' => 1.80
            ],
            [
                'codigo' => 'PROD005',
                'nombre' => 'Agua Mineral 1.5L',
                'categoria' => 'Bebidas',
                'precio_base' => 0.60,
                'costo' => 0.30
            ]
        ];

        foreach ($products as $product) {
            DimensionProduct::create($product);
        }
    }
}

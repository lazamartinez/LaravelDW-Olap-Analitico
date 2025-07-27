<?php

namespace Database\Seeders;

use App\Models\DimensionProduct;
use Illuminate\Database\Seeder;

class DimensionProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['product_code' => 'PROD001', 'name' => 'Leche Entera 1L', 'category' => 'Lácteos', 'price' => 1.20],
            ['product_code' => 'PROD002', 'name' => 'Pan Integral', 'category' => 'Panadería', 'price' => 0.85],
            ['product_code' => 'PROD003', 'name' => 'Manzanas 1kg', 'category' => 'Frutas', 'price' => 1.50],
            ['product_code' => 'PROD004', 'name' => 'Pollo Entero', 'category' => 'Carnicería', 'price' => 4.75],
            ['product_code' => 'PROD005', 'name' => 'Agua Mineral 1.5L', 'category' => 'Bebidas', 'price' => 0.60],
        ];

        foreach ($products as $product) {
            DimensionProduct::create($product);
        }
    }
}
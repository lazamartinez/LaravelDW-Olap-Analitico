<?php

namespace Database\Seeders;

use App\Models\FactSale;
use Illuminate\Database\Seeder;

class FactSaleSeeder extends Seeder
{
    public function run()
    {
        // Obtener IDs aleatorios de las dimensiones
        $timeIds = \App\Models\DimensionTime::pluck('tiempo_id')->toArray();
        $productIds = \App\Models\DimensionProduct::pluck('producto_id')->toArray();
        $customerIds = \App\Models\DimensionCustomer::pluck('cliente_id')->toArray();
        $storeIds = \App\Models\DimensionStore::pluck('sucursal_id')->toArray();
        $paymentMethods = ['Efectivo', 'Tarjeta', 'Transferencia'];

        for ($i = 0; $i < 1000; $i++) {
            $quantity = rand(1, 10);
            $price = rand(50, 500) / 10;
            $cost = $price * 0.7;
            
            FactSale::create([
                'tiempo_id' => $timeIds[array_rand($timeIds)],
                'producto_id' => $productIds[array_rand($productIds)],
                'cliente_id' => $customerIds[array_rand($customerIds)],
                'sucursal_id' => $storeIds[array_rand($storeIds)],
                'cantidad_vendida' => $quantity,
                'monto_total' => $quantity * $price,
                'descuento_total' => rand(0, $quantity * $price * 0.2),
                'costo_total' => $quantity * $cost,
                'margen_ganancia' => $quantity * ($price - $cost),
                'metodo_pago' => $paymentMethods[array_rand($paymentMethods)]
            ]);
        }
    }
}

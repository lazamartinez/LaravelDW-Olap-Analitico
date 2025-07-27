<?php

namespace Database\Seeders;

use App\Models\DimensionCustomer;
use App\Models\DimensionProduct;
use App\Models\DimensionStore;
use App\Models\DimensionTime;
use App\Models\FactSale;
use Illuminate\Database\Seeder;

class FactSalesSeeder extends Seeder
{
    public function run()
    {
        $products = DimensionProduct::all();
        $customers = DimensionCustomer::all();
        $stores = DimensionStore::all();
        $times = DimensionTime::inRandomOrder()->limit(100)->get();

        foreach ($times as $time) {
            $salesCount = rand(5, 20);
            
            for ($i = 0; $i < $salesCount; $i++) {
                $product = $products->random();
                $quantity = rand(1, 5);
                $unitPrice = $product->price;
                $totalAmount = $quantity * $unitPrice;
                $discount = rand(0, 20) / 100 * $totalAmount;
                
                FactSale::create([
                    'time_id' => $time->time_id,
                    'product_id' => $product->product_id,
                    'customer_id' => $customers->random()->customer_id,
                    'store_id' => $stores->random()->store_id,
                    'quantity_sold' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_amount' => $totalAmount,
                    'discount_amount' => $discount,
                    'net_amount' => $totalAmount - $discount,
                ]);
            }
        }
    }
}
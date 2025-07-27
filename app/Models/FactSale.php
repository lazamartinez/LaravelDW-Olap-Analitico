<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactSale extends Model
{
    use HasFactory;

    protected $table = 'dw.fact_sales';
    protected $primaryKey = 'sales_id';
    public $timestamps = false;

    protected $fillable = [
        'time_id',
        'product_id',
        'customer_id',
        'store_id',
        'quantity_sold',
        'unit_price',
        'total_amount',
        'discount_amount',
        'net_amount'
    ];

    public function time()
    {
        return $this->belongsTo(DimensionTime::class, 'time_id', 'time_id');
    }

    public function product()
    {
        return $this->belongsTo(DimensionProduct::class, 'product_id', 'product_id');
    }

    public function customer()
    {
        return $this->belongsTo(DimensionCustomer::class, 'customer_id', 'customer_id');
    }

    public function store()
    {
        return $this->belongsTo(DimensionStore::class, 'store_id', 'store_id');
    }
}
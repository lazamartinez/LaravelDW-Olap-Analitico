<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimensionProduct extends Model
{
    use HasFactory;

    protected $table = 'dw.dim_product';
    protected $primaryKey = 'product_id';
    public $timestamps = false;

    protected $fillable = [
        'product_code',
        'name',
        'category',
        'price',
        'description'
    ];
}
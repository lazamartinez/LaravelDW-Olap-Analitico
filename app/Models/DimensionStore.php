<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimensionStore extends Model
{
    use HasFactory;

    protected $table = 'dw.dim_store';
    protected $primaryKey = 'store_id';
    public $timestamps = false;

    protected $fillable = [
        'code',
        'name',
        'address',
        'city',
        'province',
        'postal_code',
        'latitude',
        'longitude'
    ];
}
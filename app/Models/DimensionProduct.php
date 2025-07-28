<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DimensionProduct extends Model
{
    protected $table = 'dw.dim_producto';
    protected $primaryKey = 'producto_id';
    public $timestamps = false;
    
    protected $fillable = [
        'codigo',
        'nombre',
        'categoria',
        'subcategoria',
        'precio_base',
        'costo'
    ];
}

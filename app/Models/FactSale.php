<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FactSale extends Model
{
    protected $table = 'dw.fact_ventas';
    protected $primaryKey = 'venta_id';
    public $timestamps = false;
    
    protected $fillable = [
        'tiempo_id',
        'producto_id',
        'cliente_id',
        'sucursal_id',
        'cantidad_vendida',
        'monto_total',
        'descuento_total',
        'costo_total',
        'margen_ganancia',
        'metodo_pago'
    ];
    
    public function time()
    {
        return $this->belongsTo(DimensionTime::class, 'tiempo_id');
    }
    
    public function product()
    {
        return $this->belongsTo(DimensionProduct::class, 'producto_id');
    }
    
    public function customer()
    {
        return $this->belongsTo(DimensionCustomer::class, 'cliente_id');
    }
    
    public function store()
    {
        return $this->belongsTo(DimensionStore::class, 'sucursal_id');
    }
}

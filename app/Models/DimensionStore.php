<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DimensionStore extends Model
{
    protected $table = 'dw.dim_sucursal';
    protected $primaryKey = 'sucursal_id';
    public $timestamps = false;
    
    protected $fillable = [
        'codigo',
        'nombre',
        'provincia',
        'canton',
        'distrito',
        'direccion_exacta',
        'telefono',
        'horario',
        'fecha_apertura',
        'activa'
    ];
}

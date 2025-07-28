<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DimensionTime extends Model
{
    protected $table = 'dw.dim_tiempo';
    protected $primaryKey = 'tiempo_id';
    public $timestamps = false;
    
    protected $fillable = [
        'fecha',
        'dia',
        'mes',
        'anio',
        'trimestre',
        'dia_semana',
        'nombre_dia',
        'nombre_mes',
        'es_fin_semana'
    ];
}
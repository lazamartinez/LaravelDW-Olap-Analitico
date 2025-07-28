<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DimensionCustomer extends Model
{
    protected $table = 'dw.dim_cliente';
    protected $primaryKey = 'cliente_id';
    public $timestamps = false;
    
    protected $fillable = [
        'identificacion',
        'nombre',
        'apellido',
        'provincia',
        'canton',
        'distrito',
        'fecha_nacimiento',
        'segmento'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimensionTime extends Model
{
    use HasFactory;

    protected $table = 'dw.dim_time';
    protected $primaryKey = 'time_id';
    public $timestamps = false;

    protected $fillable = [
        'date',
        'day',
        'month',
        'year',
        'quarter',
        'day_of_week',
        'day_name',
        'month_name',
        'is_weekend'
    ];
}
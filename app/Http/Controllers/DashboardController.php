<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FactSale;
use App\Models\DimensionStore;

class DashboardController extends Controller
{
    public function index()
    {
        // Datos de ejemplo para el dashboard
        // En un sistema real, estos datos vendrían de consultas OLAP
        
        return view('dashboard.index');
    }
}
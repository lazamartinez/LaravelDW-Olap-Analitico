<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Console\Commands\RunETLProcess;
use Illuminate\Support\Facades\Artisan;

class EtlController extends Controller
{
    public function index()
    {
        return view('etl');
    }

    public function runEtlProcess(Request $request)
    {
        try {
            $exitCode = Artisan::call(RunETLProcess::class, [
                '--incremental' => $request->has('incremental'),
                '--date' => $request->input('date'),
                '--branch' => $request->input('branches', [])
            ]);
            
            if ($exitCode === 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Proceso ETL ejecutado correctamente',
                    'output' => Artisan::output()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error en el proceso ETL',
                    'output' => Artisan::output()
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}
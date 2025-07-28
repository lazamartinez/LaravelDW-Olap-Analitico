<?php

namespace Database\Seeders;

use App\Models\DimensionTime;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DimensionTimeSeeder extends Seeder
{
    public function run()
    {
        $startDate = Carbon::now()->subYears(2);
        $endDate = Carbon::now();

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            DimensionTime::create([
                'fecha' => $date->format('Y-m-d'),
                'dia' => $date->day,
                'mes' => $date->month,
                'anio' => $date->year,
                'trimestre' => ceil($date->month / 3),
                'dia_semana' => $date->dayOfWeek,
                'nombre_dia' => $date->isoFormat('dddd'),
                'nombre_mes' => $date->isoFormat('MMMM'),
                'es_fin_semana' => $date->isWeekend(),
            ]);
        }
    }
}

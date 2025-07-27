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
                'date' => $date->format('Y-m-d'),
                'day' => $date->day,
                'month' => $date->month,
                'year' => $date->year,
                'quarter' => ceil($date->month / 3),
                'day_of_week' => $date->dayOfWeek,
                'day_name' => $date->englishDayOfWeek,
                'month_name' => $date->englishMonth,
                'is_weekend' => $date->isWeekend(),
            ]);
        }
    }
}
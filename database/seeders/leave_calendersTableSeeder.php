<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class leave_calendersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $year = Carbon::now()->year;

        // Add entries for every Saturday and Sunday of the year
        for ($month = 1; $month <= 12; $month++) {
            $daysInMonth = Carbon::create($year, $month)->daysInMonth;
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::create($year, $month, $day);
                if ($date->isWeekend()) {
                    DB::table('leave_calenders')->insert([
                        'name' => 'Weekly Holiday',
                        'start_date' => $date->format('Y-m-d'),
                        'end_date' => $date->format('Y-m-d'),
                    ]);
                }
            }
        }
    }
}

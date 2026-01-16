<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AcademicYear;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        AcademicYear::create([
            'department_id' => 1,
            'year_level' => 1,
            'year_name' => 'Year 1 - 2025/2026',
            'start_date' => '2025-10-01',
            'end_date' => '2026-07-01',
            'is_current' => true,
        ]);
    }
}

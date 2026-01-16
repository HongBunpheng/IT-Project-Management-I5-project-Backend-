<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Semester;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        Semester::create([
            'acad_year_id' => 1, // must exist
            'semester_num' => 1,
            'start_date' => '2025-10-01',
            'end_date' => '2026-02-01',
            'is_current' => true,
        ]);
    }
}

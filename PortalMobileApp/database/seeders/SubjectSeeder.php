<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        Subject::insert([
            [
                'name' => 'Mathematics',
                'description' => 'Basic mathematics',
                'credit' => 3,
                'department_id' => 1,
                'year_level' => 1,
                'semester_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Programming I',
                'description' => 'Introduction to programming',
                'credit' => 4,
                'department_id' => 1,
                'year_level' => 1,
                'semester_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

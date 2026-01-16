<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;

class GroupSeeder extends Seeder
{
    public function run(): void
    {
        Group::create([
            'name' => 'IT-2025-A',
            'department_id' => 1,
            'academic_year_id' => 1,
            'total_student' => 30,
        ]);
    }
}

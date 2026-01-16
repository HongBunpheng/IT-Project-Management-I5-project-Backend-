<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Timetable;

class TimetableSeeder extends Seeder
{
    public function run(): void
    {
        Timetable::create([
            'user_id' => 1, // teacher
            'subject_id' => 1,
            'day_of_week' => 'Mon',
            'group_id' => 1,
            'title' => 'Programming I',
            'semester_id' => 1,
            'start_time' => '08:00',
            'end_time' => '09:30',
            'class_id' => 1,
        ]);
    }
}

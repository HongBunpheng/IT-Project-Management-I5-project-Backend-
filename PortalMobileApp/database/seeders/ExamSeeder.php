<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;

class ExamSeeder extends Seeder
{
    public function run(): void
    {
        Exam::create([
            'subject_id' => 1,
            'group_id' => 1,
            'title' => 'Midterm Exam',
            'exam_type' => 'midterm',
            'exam_date' => '2026-01-20',
            'total_mark' => 100,
            'start_time' => '08:00',
            'end_time' => '10:00',
        ]);

        Exam::create([
            'subject_id' => 1,
            'group_id' => 1,
            'title' => 'Final Exam',
            'exam_type' => 'final',
            'exam_date' => '2026-03-10',
            'total_mark' => 100,
            'start_time' => '13:00',
            'end_time' => '15:00',
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Score;

class ScoreSeeder extends Seeder
{
    public function run(): void
    {
        // Student user_id = 1
        Score::create([
            'exam_id' => 1,
            'user_id' => 1,
            'score' => 78,
            'grade' => 'C+',
            'remark' => 'Need improvement',
        ]);

        Score::create([
            'exam_id' => 2,
            'user_id' => 1,
            'score' => 92,
            'grade' => 'A',
            'remark' => 'Excellent',
        ]);
    }
}

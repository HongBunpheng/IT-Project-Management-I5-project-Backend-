<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            DepartmentSeeder::class,
            AcademicYearSeeder::class,
            SemesterSeeder::class,
            BuildingSeeder::class,
            ClassRoomSeeder::class,
            GroupSeeder::class,
            UserSeeder::class,
            SubjectSeeder::class,
            TimetableSeeder::class,
            ExamSeeder::class,
            ScoreSeeder::class,
        ]);
    }
}

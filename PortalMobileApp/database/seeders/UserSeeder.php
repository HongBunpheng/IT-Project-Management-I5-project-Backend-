<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin / Teacher
        User::create([
            'user_name' => 'Teacher One',
            'email' => 'teacher@school.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'group_id' => null,
            'department_id' => 1,
        ]);

        // Student
        User::create([
            'user_name' => 'Student One',
            'email' => 'student@school.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'group_id' => 1,
            'department_id' => 1,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassRoom;

class ClassRoomSeeder extends Seeder
{
    public function run(): void
    {
        ClassRoom::create([
            'name' => 'Room 101',
            'building_id' => 1,
            'floor' => 1,
            'room_type' => 'normal',
        ]);

        ClassRoom::create([
            'name' => 'Lab 201',
            'building_id' => 1,
            'floor' => 2,
            'room_type' => 'lab',
        ]);
    }
}

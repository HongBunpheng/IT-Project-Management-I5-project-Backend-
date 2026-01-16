<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Building;

class BuildingSeeder extends Seeder
{
    public function run(): void
    {
        Building::create([
            'name' => 'Main Building',
            'address' => 'Campus A',
            'code' => 'B1',
        ]);
    }
}

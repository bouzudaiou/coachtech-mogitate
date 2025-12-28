<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Season;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Season::create(['name' => '春']);
        Season::create(['name' => '夏']);
        Season::create(['name' => '秋']);
        Season::create(['name' => '冬']);
    }
}

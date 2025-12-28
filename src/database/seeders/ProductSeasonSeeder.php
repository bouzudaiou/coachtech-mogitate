<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Season;

class ProductSeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::find(1)->seasons()->attach([3, 4]);
        Product::find(2)->seasons()->attach([1]);
        Product::find(3)->seasons()->attach([4]);
        Product::find(4)->seasons()->attach([2]);
        Product::find(5)->seasons()->attach([2]);
        Product::find(6)->seasons()->attach([2, 3]);
        Product::find(7)->seasons()->attach([1, 2]);
        Product::find(8)->seasons()->attach([2, 3]);
        Product::find(9)->seasons()->attach([2]);
        Product::find(10)->seasons()->attach([1, 2]);
    }
}

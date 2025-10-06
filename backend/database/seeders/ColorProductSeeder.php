<?php

namespace Database\Seeders;

use App\Models\ColorProduct;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ColorProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      ColorProduct::factory()->count(10)->create();
    }
}

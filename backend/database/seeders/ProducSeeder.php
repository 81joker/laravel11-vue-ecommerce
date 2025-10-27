<?php

namespace Database\Seeders;

use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProducSeeder extends Seeder
{
    
public function run(): void
    {
        foreach (['S','M','L','XL','XXL'] as $s) {
            Size::firstOrCreate(['name' => $s]);
        }

        $baseColors = ['Red','Blue','Green','Yellow','Black','White','Purple','Orange','Pink','Brown'];
        foreach ($baseColors as $c) {
            Color::firstOrCreate(['name' => $c]);
        }

        Product::factory()->count(10)->create()->each(function (Product $product) {
            // attach ALL sizes (so every product has sizes)
            $product->sizes()->syncWithoutDetaching(Size::pluck('id'));

            // attach some random colors (guaranteed >=1)
            $colorCount = max(1, min(4, Color::count()));
            $colorIds   = Color::inRandomOrder()->take($colorCount)->pluck('id');
            $product->colors()->syncWithoutDetaching($colorIds);
        });
    }
}

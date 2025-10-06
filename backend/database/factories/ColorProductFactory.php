<?php

namespace Database\Factories;

use App\Models\ColorProduct;
use App\Models\Product;
use App\Models\Color;
use Illuminate\Database\Eloquent\Factories\Factory;

class ColorProductFactory extends Factory
{
    protected $model = ColorProduct::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'color_id' => Color::factory(),
        ];
    }
}
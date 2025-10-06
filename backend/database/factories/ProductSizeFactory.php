<?php

namespace Database\Factories;

use App\Models\Size;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductSizeFactory extends Factory
{
    protected $model = ProductSize::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'size_id' => Size::factory(),
        ];
    }
}
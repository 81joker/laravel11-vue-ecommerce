<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProducFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'qty' => $this->faker->numberBetween(1, 100),
            'price' => $this->faker->numberBetween(1000, 100000),
            'desc' => $this->faker->paragraph(),
            'thumbnail' => $this->faker->imageUrl(640, 480, 'technics', true),
            'first_image' => $this->faker->imageUrl(640, 480, 'technics', true),
            'second_image' => $this->faker->imageUrl(640, 480, 'technics', true),
            'third_image' => $this->faker->imageUrl(640, 480, 'technics', true),
            'status' => $this->faker->boolean(),
            'category_id' => \App\Models\Category::factory(),
            'brand_id' => \App\Models\Brand::factory(),
        ];
    }
}

   
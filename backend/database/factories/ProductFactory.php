<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
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
            // 'thumbnail' => $this->faker->imageUrl(640, 480, 'technics', true),
            'thumbnail' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NzEyNjZ8MHwxfHNlYXJjaHwxfHxzaG9lfGVufDB8MHx8fDE3MjEwNDEzNjd8MA&ixlib=rb-4.0.3&q=80&w=1080',
            'first_image' => $this->faker->imageUrl(640, 480, 'technics', true),
            'second_image' => $this->faker->imageUrl(640, 480, 'technics', true),
            'third_image' => $this->faker->imageUrl(640, 480, 'technics', true),
            'status' => $this->faker->boolean(),
            'category_id' => $this->faker->numberBetween(1, 10),
            'brand_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}

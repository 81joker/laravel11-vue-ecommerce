<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Electronics', 'Books', 'Clothing', 
        'Home & Kitchen', 'Sports & Outdoors', 'Toys & Games', 
        'Health & Personal Care', 'Automotive', 'Beauty', 'Grocery'];
        $name = $this->faker->unique()->randomElement($categories);
        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            // add other fillable columns with sensible defaults if you have them
        ];
    }   
}

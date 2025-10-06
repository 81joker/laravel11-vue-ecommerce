<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Color>
 */
class ColorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       $colors = ['Red', 'Blue', 'Green', 'Yellow', 'Black', 'White', 'Purple', 'Orange', 'Pink', 'Brown', 'Gray', 'Cyan', 'Magenta', 'Lime', 'Maroon', 'Navy', 'Olive', 'Teal', 'Silver', 'Gold'];
        return [
            'name' => $this->faker->unique()->randomElement($colors),
        ];
    }
}

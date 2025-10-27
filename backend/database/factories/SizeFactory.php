<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Size>
 */
class SizeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // static $sizes = ['S', 'M', 'L', 'XL', 'XXL'];
        // static $index = 0;

        // $name = $sizes[$index % count($sizes)];
        // $index++;

        // return ['name' => $name];
         static $sizes = ['S', 'M', 'L', 'XL', 'XXL'];
        static $i = 0;

        return ['name' => $sizes[$i++ % count($sizes)]];
    }
}

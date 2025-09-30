<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use App\Models\Admin;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Admin::factory()->create([
            'email' => 'admin@example.com',
        ]);


        Category::factory(10)->create();
        $this->call([
            AdminSeeder::class,
            BrandSeeder::class,
        ]);
    }
}

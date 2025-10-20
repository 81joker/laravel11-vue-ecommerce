<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Admin;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Database\Seeders\SizeSeeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\ColorSeeder;
use Database\Seeders\CouponSeeder;
use Database\Seeders\ProducSeeder;
use Database\Seeders\ProductSizeSeeder;
use Database\Seeders\ColorProductSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'email' => 'tim26618@gamil.com',
        ]);
        Admin::factory()->create([
            'email' => 'admin@example.com',
        ]);


        Category::factory(10)->create();
        $this->call([
            AdminSeeder::class,
            BrandSeeder::class,
            SizeSeeder::class,
            ColorSeeder::class,
            ProducSeeder::class,
            ColorProductSeeder::class,
            ProductSizeSeeder::class,
            CouponSeeder::class,
        ]);
    }
}

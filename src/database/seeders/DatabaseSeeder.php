<?php

namespace Database\Seeders;
// Support
use Illuminate\Database\Seeder;
// Models
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountryTableSeeder::class,
            ProvinceTableSeeder::class
        ]);

        User::factory()->count(10)->create();
        Category::factory()->count(5)->create();
        Product::factory()->count(20)->create();
    }
}

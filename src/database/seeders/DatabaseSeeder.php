<?php

namespace Database\Seeders;
// Support
use Illuminate\Database\Seeder;
// Models
use App\Models\Bundle;
use App\Models\Category;
use App\Models\Section;
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
        Section::factory()->count(5)->create();
        Bundle::factory()->count(20)->create();

        // populate bundle-product table (many-to-many)
        $bundles = Bundle::all();
        Product::all()->each(function ($product) use ($bundles) {
            $product->bundles()->attach(
                $bundles->random(2)->pluck('id')->toArray(),
                ['default_quantity' => rand(1, 10)]
            );
        });
    }
}

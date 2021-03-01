<?php

namespace Database\Factories;
// Support
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
// Models
use App\Models\Category;
use App\Models\Product;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $categories = Category::all();
        $product_suffixes = ['Sweater', 'Pants', 'Shirt', 'Glasses', 'Hat', 'Socks'];
        $name = $this->faker->company . ' ' . Arr::random($product_suffixes);

        return [
            'category_id'   => $categories->random(1)
                ->first()
                ->id,
            'name'          => $name,
            'slug'          => Str::slug($name),
            'description'   => $this->faker->realText(320),
            'image_path'    => $this->faker->imageUrl(640, 480, 'cats', true, 'Faker'),
            'price'         => $this->faker->numberBetween(10000, 100000), // $100.00 - $1000.00
            'qnt_left'      => $this->faker->randomDigit()
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // will generate multiple words;
        $name = $this->faker->jobTitle;

        $nameArr = explode(' ', $name);
        $name = trim($nameArr[0]);
        return [
            'name'          => $name,
            'slug'          => Str::slug($name),
            'description'   => $this->faker->realText(120),
            'image_path'    => $this->faker->imageUrl(640, 480, 'cats', true, 'Faker')
        ];
    }
}

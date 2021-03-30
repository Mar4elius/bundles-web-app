<?php

namespace Database\Factories;
// Support
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
// Models
use App\Models\Bundle;
use App\Models\Section;

class BundleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bundle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sections = Section::all();
        $name = $this->faker->jobTitle;

        $name_arr = explode(' ', $name);
        $name = trim($name_arr[0]) . ' bundle';



        return [
            'section_id'    => $sections->random(1)
                ->first()
                ->id,
            'name'          => $name,
            'slug'          => Str::slug($name),
            'price'         => $this->faker->numberBetween(1000, 10000), //$10.00 - $100.00
            'description'   => $this->faker->realText(120),
            'image_path'    => $this->faker->imageUrl(640, 480, 'dogs', true, 'Faker'),
            'popularity'    => $this->faker->randomDigit
        ];
    }
}

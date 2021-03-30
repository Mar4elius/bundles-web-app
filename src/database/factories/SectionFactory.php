<?php

namespace Database\Factories;
// Support
use App\Models\Section;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Section::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->jobTitle;

        $nameArr = explode(' ', $name);
        $name = trim($nameArr[0]);

        return [
            'name'          => $name,
            'slug'          => Str::slug($name),
            'description'   => $this->faker->realText(120),
            'image_path'    => $this->faker->imageUrl(640, 480, 'cats', true)
        ];
    }
}

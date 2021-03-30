<?php

namespace Database\Seeders;
// Models
use App\Models\Tag;
// Support
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['sport', 'friends', 'date', 'travel', 'move night', 'babies'];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(
                ['name' => $tag],
                [
                    'slug' => Str::slug($tag)
                ]
            );
        }
    }
}

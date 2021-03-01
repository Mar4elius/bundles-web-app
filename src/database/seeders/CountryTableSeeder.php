<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::firstOrCreate(
            ['name' => 'Canada'],
            ['code' => 'CA']
        );

        Country::firstOrCreate(
            ['name' => 'USA'],
            ['code' => 'US']
        );
    }
}

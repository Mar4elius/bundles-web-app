<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// Models
use App\Models\Country;
use App\Models\Province;

class ProvinceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $canada = Country::whereCode('CA')->first();
        $usa = Country::whereCode('US')->first();

        $provinces = array(
            // Canada
            array('country_id' => $canada->id, 'abbreviation' => 'AB', 'name' => 'Alberta'),
            array('country_id' => $canada->id, 'abbreviation' => 'BC', 'name' => 'British Columbia'),
            array('country_id' => $canada->id, 'abbreviation' => 'MB', 'name' => 'Manitoba'),
            array('country_id' => $canada->id, 'abbreviation' => 'NB', 'name' => 'New Brunswick'),
            array('country_id' => $canada->id, 'abbreviation' => 'NL', 'name' => 'Newfoundland and Labrador'),
            array('country_id' => $canada->id, 'abbreviation' => 'NT', 'name' => 'Northwest Territories'),
            array('country_id' => $canada->id, 'abbreviation' => 'NS', 'name' => 'Nova Scotia'),
            array('country_id' => $canada->id, 'abbreviation' => 'NU', 'name' => 'Nunavut'),
            array('country_id' => $canada->id, 'abbreviation' => 'ON', 'name' => 'Ontario'),
            array('country_id' => $canada->id, 'abbreviation' => 'PE', 'name' => 'Prince Edward Island'),
            array('country_id' => $canada->id, 'abbreviation' => 'QC', 'name' => 'Quebec'),
            array('country_id' => $canada->id, 'abbreviation' => 'SK', 'name' => 'Saskatchewan'),
            array('country_id' => $canada->id, 'abbreviation' => 'YT', 'name' => 'Yukon'),

            // USA
            array('country_id' => $usa->id, 'abbreviation' => 'AL', 'name' => 'Alabama'),
            array('country_id' => $usa->id, 'abbreviation' => 'AK', 'name' => 'Alaska'),
            array('country_id' => $usa->id, 'abbreviation' => 'AZ', 'name' => 'Arizona'),
            array('country_id' => $usa->id, 'abbreviation' => 'AR', 'name' => 'Arkansas'),
            array('country_id' => $usa->id, 'abbreviation' => 'CA', 'name' => 'California'),
            array('country_id' => $usa->id, 'abbreviation' => 'CO', 'name' => 'Colorado'),
            array('country_id' => $usa->id, 'abbreviation' => 'CT', 'name' => 'Connecticut'),
            array('country_id' => $usa->id, 'abbreviation' => 'DE', 'name' => 'Delaware'),
            array('country_id' => $usa->id, 'abbreviation' => 'FL', 'name' => 'Florida'),
            array('country_id' => $usa->id, 'abbreviation' => 'GA', 'name' => 'Georgia'),
            array('country_id' => $usa->id, 'abbreviation' => 'HI', 'name' => 'Hawaii'),
            array('country_id' => $usa->id, 'abbreviation' => 'ID', 'name' => 'Idaho'),
            array('country_id' => $usa->id, 'abbreviation' => 'IL', 'name' => 'Illinois'),
            array('country_id' => $usa->id, 'abbreviation' => 'IN', 'name' => 'Indiana'),
            array('country_id' => $usa->id, 'abbreviation' => 'IA', 'name' => 'Iowa'),
            array('country_id' => $usa->id, 'abbreviation' => 'KS', 'name' => 'Kansas'),
            array('country_id' => $usa->id, 'abbreviation' => 'KY', 'name' => 'Kentucky'),
            array('country_id' => $usa->id, 'abbreviation' => 'LA', 'name' => 'Louisiana'),
            array('country_id' => $usa->id, 'abbreviation' => 'ME', 'name' => 'Maine'),
            array('country_id' => $usa->id, 'abbreviation' => 'MD', 'name' => 'Maryland'),
            array('country_id' => $usa->id, 'abbreviation' => 'MA', 'name' => 'Massachusetts'),
            array('country_id' => $usa->id, 'abbreviation' => 'MI', 'name' => 'Michigan'),
            array('country_id' => $usa->id, 'abbreviation' => 'MN', 'name' => 'Minnesota'),
            array('country_id' => $usa->id, 'abbreviation' => 'MS', 'name' => 'Mississippi'),
            array('country_id' => $usa->id, 'abbreviation' => 'MO', 'name' => 'Missouri'),
            array('country_id' => $usa->id, 'abbreviation' => 'MT', 'name' => 'Montana'),
            array('country_id' => $usa->id, 'abbreviation' => 'NE', 'name' => 'Nebraska'),
            array('country_id' => $usa->id, 'abbreviation' => 'NV', 'name' => 'Nevada'),
            array('country_id' => $usa->id, 'abbreviation' => 'NH', 'name' => 'New Hampshire'),
            array('country_id' => $usa->id, 'abbreviation' => 'NJ', 'name' => 'New Jersey'),
            array('country_id' => $usa->id, 'abbreviation' => 'NM', 'name' => 'New Mexico'),
            array('country_id' => $usa->id, 'abbreviation' => 'NY', 'name' => 'New York'),
            array('country_id' => $usa->id, 'abbreviation' => 'NC', 'name' => 'NC'),
            array('country_id' => $usa->id, 'abbreviation' => 'ND', 'name' => 'North Dakota'),
            array('country_id' => $usa->id, 'abbreviation' => 'OH', 'name' => 'Ohio'),
            array('country_id' => $usa->id, 'abbreviation' => 'OK', 'name' => 'Oklahoma'),
            array('country_id' => $usa->id, 'abbreviation' => 'OR', 'name' => 'Oregon'),
            array('country_id' => $usa->id, 'abbreviation' => 'PA', 'name' => 'Pennsylvania'),
            array('country_id' => $usa->id, 'abbreviation' => 'RI', 'name' => 'Rhode Island'),
            array('country_id' => $usa->id, 'abbreviation' => 'SC', 'name' => 'South Carolina'),
            array('country_id' => $usa->id, 'abbreviation' => 'SD', 'name' => 'South Dakota'),
            array('country_id' => $usa->id, 'abbreviation' => 'TN', 'name' => 'Tennessee'),
            array('country_id' => $usa->id, 'abbreviation' => 'TX', 'name' => 'Texas'),
            array('country_id' => $usa->id, 'abbreviation' => 'UT', 'name' => 'Utah'),
            array('country_id' => $usa->id, 'abbreviation' => 'VT', 'name' => 'Vermont'),
            array('country_id' => $usa->id, 'abbreviation' => 'VA', 'name' => 'Virginia'),
            array('country_id' => $usa->id, 'abbreviation' => 'WA', 'name' => 'Washington'),
            array('country_id' => $usa->id, 'abbreviation' => 'WV', 'name' => 'West Virginia'),
            array('country_id' => $usa->id, 'abbreviation' => 'WI', 'name' => 'Wisconsin'),
            array('country_id' => $usa->id, 'abbreviation' => 'WY', 'name' => 'Wyoming'),
            array('country_id' => $usa->id, 'abbreviation' => 'AS', 'name' => 'American Samoa'),
            array('country_id' => $usa->id, 'abbreviation' => 'DC', 'name' => 'District of Columbia'),
            array('country_id' => $usa->id, 'abbreviation' => 'GU', 'name' => 'Guam'),
            array('country_id' => $usa->id, 'abbreviation' => 'MP', 'name' => 'Northern Mariana Islands'),
            array('country_id' => $usa->id, 'abbreviation' => 'PR', 'name' => 'Puerto Rico'),
            array('country_id' => $usa->id, 'abbreviation' => 'VI', 'name' => 'United States Virgin Islands'),
        );

        foreach ($provinces as $province) {
            Province::firstOrCreate(
                ['abbreviation'  => $province['abbreviation']],
                [
                    'country_id' => $province['country_id'] === $canada->id ? $canada->id : $usa->id,
                    'name'       => $province['name']
                ]
            );
        }
    }
}

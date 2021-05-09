<?php

namespace App\Http\Controllers\Api;

// Support
use App\Http\Controllers\Controller;
// Models
use App\Models\Country;
use App\Models\Province;

class OptionController extends Controller
{
    /**
     * Get all available countries
     *
     * @return \Illuminate\Http\Response
     */
    public function getCountries()
    {
        $countries = Country::all();

        return response()->json([
            'countries' => $countries
        ]);
    }

    /**
     * Get all country provinces
     * 
     * @param \App\Models\Country $country
     *
     * @return \Illuminate\Http\Response
     */
    public function getProvinces(Province $country)
    {
        $provinces = Province::whereCountryId($country->id)
            ->get();

        return response()->json([
            'provinces' => $provinces
        ]);
    }
}

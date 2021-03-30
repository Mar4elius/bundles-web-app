<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// Models
use App\Models\Bundle;
use App\Models\Category;
use App\Models\Section;
// Requests
use App\Http\Requests\Api\FilterBundlesRequest;

class BundleController extends Controller
{
    /**
     * Filter available bundles based on path param
     *
     * @param App\Http\Requests\Api\FilterBundlesRequest $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filterBundles(FilterBundlesRequest $request)
    {
        $term = $request->term;
        $bundles = null;

        if ($term === 'all') {
            $bundles = Section::with('bundles')
                ->get();
        } else {
            $bundles = Section::with('bundles')
                ->whereSlug($term)
                ->get();
        }

        return response()->json([
            'bundles' => $bundles
        ]);
    }
}

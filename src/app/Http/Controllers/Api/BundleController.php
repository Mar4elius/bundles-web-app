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

        $bundles = Section::with([
            'bundles.products' => function ($q) {
                return $q->withPivot('default_quantity');
            },
            'bundles.tags'
        ]);
        if ($term === 'all') {
            $bundles = $bundles->get();
        } else {
            $bundles = $bundles->whereSlug($term)
                ->get();
        }

        return response()->json([
            'bundles' => $bundles
        ]);
    }
}

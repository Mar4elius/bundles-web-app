<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Bundles\SortBundlesRequest as BundlesSortBundlesRequest;
// Models
use App\Models\Bundle;
use App\Models\Section;
// Requests
use App\Http\Requests\Api\Bundles\FilterBundlesRequest;
use App\Http\Requests\Api\Bundles\SortBundlesRequest;

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
        // TODO: Add try catch block
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

    /**
     * Sort available bundles based on path param
     *
     * @param App\Http\Requests\Api\SortBundlesRequest $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sortBundles(BundlesSortBundlesRequest $request)
    {
        // TODO: Add try catch block
        $sort_by = $request->sort_by;
        $most_popular_bundles = Bundle::orderBy($sort_by, 'desc')
            ->with([
                'products' => function ($q) {
                    return $q->withPivot('default_quantity');
                },
                'tags'
            ])
            ->take(10)
            ->get();

        return response()->json([
            'bundles' => $most_popular_bundles
        ]);
    }
}

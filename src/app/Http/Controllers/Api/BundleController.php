<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// Models
use App\Models\Bundle;
use App\Models\Tag;
use App\Models\Section;
// Requests
use App\Http\Requests\Api\Bundles\SearchBundlesRequest;
use App\Http\Requests\Api\Bundles\GetTopTenBundlesRequest;

class BundleController extends Controller
{
    /**
     * Filter available bundles based on path param
     *
     * @param App\Http\Requests\Api\SearchBundlesRequest $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function search(SearchBundlesRequest $request)
    {
        // TODO: Add try catch block
        $bundles = null;

        $sections = $request->sections;
        $tags = $request->tags;
        // dd($tags);

        $bundles = Section::with([
            'bundles.products' => function ($q) {
                return $q->withPivot('default_quantity');
            }
        ]);

        // filter by section
        if (!in_array('all', $sections)) {
            $bundles = $bundles->whereIn('slug', $sections);
        }

        // filter by tags
        if (in_array('all', $tags)) {
            $bundles->with('bundles.tags');
        } else {
            $bundles->with([
                'bundles.tags' => function ($q) use ($tags) {
                    return $q->whereIn('slug', $tags);
                }
            ]);
        }

        $bundles = $bundles->get();

        return response()->json([
            'bundles' => $bundles
        ]);
    }

    /**
     * Sort available bundles based on path param
     *
     * @param App\Http\Requests\Api\Bundles\GetTopTenBundlesRequest $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getTopTenBundles(GetTopTenBundlesRequest $request)
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

    /**
     * Get bundles filter options
     *
     * * @return \Symfony\Component\HttpFoundation\Response
     */

    public function getFilterOptions()
    {
        $sections = Section::all();
        $tags = Tag::all();

        return response()->json([
            'sections'  => $sections,
            'tags'      => $tags
        ]);
    }
}

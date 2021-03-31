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
        $filter_params = $request->params;
        $bundles = null;

        $sections = Section::all()->pluck('slug');
        $tags = Tag::all()->pluck('slug');
        // get only values that have been selected on the front end
        $section_slugs = $sections->intersect($filter_params)->count() ? $sections->intersect($filter_params) : ['all'];
        $tag_slugs = $tags->intersect($filter_params)->count() ? $tags->intersect($filter_params) : ['all'];

        $bundles = Section::with([
            'bundles.products' => function ($q) {
                return $q->withPivot('default_quantity');
            }
        ]);

        // filter by section
        if (!in_array('all', $section_slugs)) {
            $bundles = $bundles->whereIn('slug', $section_slugs);
        }

        // filter by tags
        // none OR All is selected
        if (in_array('all', $tag_slugs)) {
            $bundles->with('bundles.tags');
        } else {
            $bundles->with([
                'bundles.tags' => function ($q) use ($tag_slugs) {
                    return $q->whereIn('slug', $tag_slugs);
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

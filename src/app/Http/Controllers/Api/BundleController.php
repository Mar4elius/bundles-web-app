<?php

namespace App\Http\Controllers\Api;
// Support
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Exception;
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
        try {
            $bundles = null;

            $sections = $request->sections;
            $tags = $request->tags;

            $bundles = Section::with([
                'bundles.products' => function ($q) {
                    return $q->withPivot('default_quantity');
                },
                'bundles.tags'
            ]);

            // filter by section
            if (!in_array('all', $sections)) {
                $bundles = $bundles->WhereIn('slug', $sections);
            }

            // filter by tags
            if (!in_array('all', $tags)) {
                // filter section based on if bundle has selected tag
                $bundles->whereHas(
                    'bundles.tags',
                    function ($q) use ($tags) {
                        return $q->whereIn('slu', $tags);
                    }
                )->with(
                    // now filter bundles based on the selected tag
                    'bundles',
                    function ($q) use ($tags) {
                        $q->whereHas('tags', function ($q) use ($tags) {
                            $q->whereIn('slug', $tags);
                        });
                    }
                );
            }

            // build order clause MAYBE FILLED?
            if (isset($request->sort_by)) {
                $bundles->with('bundles', function ($q) use ($request) {
                    foreach ($request->sort_by as $sort) {
                        $sort = json_decode($sort);
                        if ($sort->order) {
                            $q->orderBy($sort->name, $sort->order);
                        }
                    }
                });
            }

            $bundles = $bundles->get();

            return response()->json([
                'bundles' => $bundles
            ]);
        } catch (Exception $e) {
            if (config('app.env') !== 'production') {
                return $e->getMessage();
            } else {
                Log::error($e->getMessage());
                return response()->json([
                    'error' => 'This request failed successfully in bundle search.'
                ], 500);
            }
        }
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
        try {
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
        } catch (Exception $e) {
            if (config('app.env') !== 'production') {
                return $e->getMessage();
            } else {
                Log::error($e->getMessage());
                return response()->json([
                    'error' => 'This request failed successfully in getTopTenBundles.'
                ], 500);
            }
        }
    }

    /**
     * Get bundles filter options
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function getFilterOptions()
    {
        try {
            $sections = Section::whereHas('bundles')
                ->get();
            $tags = Tag::all();

            return response()->json([
                'sections'  => $sections,
                'tags'      => $tags
            ]);
        } catch (Exception $e) {
            if (config('app.env') !== 'production') {
                return $e->getMessage();
            } else {
                Log::error($e->getMessage());
                return response()->json([
                    'error' => 'This request failed successfully in getFilterOptions.'
                ], 500);
            }
        }
    }

    /**
     * Get bundles sort options
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function getSortOptions()
    {
        try {
            // build data set for radio buttons
            $sorts = [
                [
                    'group_name'    => 'popularity',
                    'orders' => [
                        'asc'           => [
                            'name'  => 'popularity',
                            'id'    => 'popularity_asc',
                            'value' => 'asc'
                        ],
                        'desc' => [
                            'name'  => 'popularity',
                            'id'    => 'popularity_desc',
                            'value' => 'desc'
                        ],
                    ]
                ],
                [
                    'group_name'    => 'price',
                    'orders' => [
                        'asc' => [
                            'name'  => 'price',
                            'id'    => 'price_asc',
                            'value' => 'asc'
                        ],
                        'desc' => [
                            'name'  => 'price',
                            'id'    => 'price_desc',
                            'value' => 'desc'
                        ],
                    ]
                ]
            ];

            return response()->json([
                'sorts'  => $sorts
            ]);
        } catch (Exception $e) {
            if (config('app.env') !== 'production') {
                return $e->getMessage();
            } else {
                Log::error($e->getMessage());
                return response()->json([
                    'error' => 'This request failed successfully in getSortOptions.'
                ], 500);
            }
        }
    }
}

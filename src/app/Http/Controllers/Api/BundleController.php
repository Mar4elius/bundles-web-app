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
use App\Http\Requests\Api\Bundles\GetAdditionalBundlesRequest;
use App\Http\Requests\Api\Bundles\GetBundleDetailsRequest;

class BundleController extends Controller
{
    /**
     * Filter and Sort available bundles based on path param
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
                // filter by section
            ])->when(!in_array('all', $sections), function ($q) use ($sections) {
                return $q->whereIn('slug', $sections);
                // filter by tags
            })->when(!in_array('all', $tags), function ($q) use ($tags) {
                return $q->whereHas(
                    'bundles.tags',
                    function ($q) use ($tags) {
                        return $q->whereIn('slug', $tags);
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
                // build order clause 
            })->when(isset($request->sort_by), function ($q) use ($request) {
                $q->with('bundles', function ($q) use ($request) {
                    foreach ($request->sort_by as $sort) {
                        $sort = json_decode($sort);
                        if ($sort->order) {
                            $q->orderBy($sort->name, $sort->order);
                        }
                    }
                });
            })->get();

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
     * Get general bundles data
     *
     * @param App\Http\Requests\Api\Bundles\GetAdditionalBundlesRequest $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAdditionalBundles(GetAdditionalBundlesRequest $request)
    {
        try {
            $request_bundle = $request->bundle ? json_decode($request->bundle) : null;
            $use_sort = $request->sort_by && $request->order;

            $bundles = Bundle::withProductsPivot()
                ->with([
                    'tags',
                    'section'
                    // don't include current bundle if provided
                ])->when($request_bundle && $request_bundle->bundle_id, function ($q) use ($request_bundle) {
                    return $q->where('id', '!=', $request_bundle->bundle_id);
                    // section id check
                })->when($request_bundle && $request_bundle->section_id, function ($q) use ($request_bundle) {
                    return $q->whereSectionId($request_bundle->section_id);
                    // sort by and order check
                })->when($use_sort, function ($q) use ($request) {
                    return $q->orderBy($request->sort_by, $request->order);
                    // quantity check
                })->when($request->quantity, function ($q) use ($request) {
                    return $q->take($request->quantity);
                })->get();

            return response()->json([
                'bundles' => $bundles
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

    /**
     * Get bundle details
     *
     * @param App\Http\Requests\Api\Bundles\GetBundleDetailsRequest $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getBundleDetails(GetBundleDetailsRequest $request)
    {
        try {
            $bundle = Bundle::whereSlug($request->slug)
                ->withProductsPivot()
                ->with('section')
                ->firstOrFail();

            return response()->json([
                'bundle' => $bundle
            ]);
        } catch (Exception $e) {
            if (config('app.env') !== 'production') {
                return $e->getMessage();
            } else {
                Log::error($e->getMessage());
                return response()->json([
                    'error' => 'This request failed successfully in bundle details.'
                ]);
            }
        }
    }
}

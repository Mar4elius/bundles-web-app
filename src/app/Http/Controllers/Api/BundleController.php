<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        dd($request->all());

        return response()->json([
            //
        ]);
    }
}

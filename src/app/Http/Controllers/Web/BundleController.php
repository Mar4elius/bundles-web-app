<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BundleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $most_popular_bundles = Bundle::orderBy('popularity', 'desc')
            ->with('products')
            ->take(10)
            ->get();

        return Inertia::render('HomePage', [
            'bundles' => $most_popular_bundles
        ]);
    }
}

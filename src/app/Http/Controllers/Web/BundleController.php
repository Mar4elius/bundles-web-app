<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BundleController extends Controller
{
    /**
     * Get most popular bundles based on popularity
     *
     * @return Inertia\Inertia
     */
    public function getMostPopularBundles()
    {
        $most_popular_bundles = Bundle::orderBy('popularity', 'desc')
            ->with('products', function ($q) {
                return $q->withPivot('default_quantity');
            })
            ->take(10)
            ->get();

        return Inertia::render('HomePage', [
            'bundles' => $most_popular_bundles
        ]);
    }

    /**
     * Get all available bundles with categories
     *
     * @return Inertia\Inertia
     */
    public function getBundles()
    {
        $categories = Category::all();
        return Inertia::render('Bundle/BundlesPage', [
            'categories' => $categories
        ]);
    }
}

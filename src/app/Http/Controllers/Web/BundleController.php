<?php

namespace App\Http\Controllers\Web;
// Support
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;
use Inertia\Inertia;
// Models
use App\Models\Bundle;
use App\Models\Section;

class BundleController extends Controller
{
    /**
     * Display a listing of the bundles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Bundle/BundlesIndexPage');
    }

    /**
     * Get all available bundles with categories
     *
     * @return Inertia\Inertia
     */
    public function search()
    {
        return Inertia::render('Bundle/BundlesSearchPage');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug)
    {
        $bundle = Bundle::whereSlug($slug)
            ->with('section')
            ->first();

        return Inertia::render('Bundle/BundleDetailsPage', [
            'bundle' => $bundle
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

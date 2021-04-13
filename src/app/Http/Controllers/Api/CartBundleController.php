<?php

namespace App\Http\Controllers\Api;
// Support
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Models
use App\Models\CartBundle;

class CartBundleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart_bundle = new CartBundle();
        $cart_bundle->cart_id = $request->cart_id;
        $cart_bundle->quantity = $request->quantity;
        $cart_bundle->price_per_bundle = $request->cart_sub_total;
        $cart_bundle->image_path = $request->image_path;
        $cart_bundle->save();

        // add products that are related to the bundle
        $products = $request->products;
        foreach ($products as $product) {
            $cart_bundle->products()->attach($product['id'], [
                'quantity' => $product['quantity']
            ]);
        }

        return response()->json([
            'cart' => $cart->refresh(),
            'message' => 'Bundle has been added to the cart.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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

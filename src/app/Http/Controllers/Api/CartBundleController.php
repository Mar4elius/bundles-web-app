<?php

namespace App\Http\Controllers\Api;
// Support
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// Models
use App\Models\CartBundle;
use App\Models\Cart;

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
        $cart = Cart::find($request->cart_id);
        DB::transaction(function () use ($cart, $request) {
            // create cart bundle record
            $cart_bundle = new CartBundle();
            $cart_bundle->cart_id = $cart->id;
            $cart_bundle->name = $request->name;
            $cart_bundle->quantity = $request->quantity;
            $cart_bundle->price_per_bundle = $request->price;
            $cart_bundle->image_path = $request->image_path;
            $cart_bundle->save();

            // create cartBundle-Product record
            $products = $request->products;
            foreach ($products as $product) {
                $cart_bundle->products()->attach($product['id'], [
                    'quantity' => $product['quantity']
                ]);
            }
        });

        // get all cart bundles that belong to cart
        $cart_bundles = CartBundle::whereCartId($cart->id)
            ->with('products')
            ->get();
        return response()->json([
            'cart_bundles' => $cart_bundles,
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

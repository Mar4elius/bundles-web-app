<?php

namespace App\Http\Controllers\Api;

// Support
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
// Models
use App\Models\Cart;
use App\Models\CartBundle;

class CartController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart = new Cart();
        DB::transaction(function () use ($cart, $request) {
            // create cart
            $cart->sub_total = $request->cart_sub_total;
            $cart->save();

            // create cart bundle record
            $cart_bundle = new CartBundle();
            $cart_bundle->cart_id = $cart->id;
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

        return response()->json([
            'cart' => $cart->refresh(),
            'message' => 'Bundle has been added to the cart.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\Cart $cart
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $cart = Cart::find($id);
            if ($cart) {
                $cart->load(['cartBundles.products' => function ($q) {
                    return $q->withPivot('quantity');
                }])->get();
            } else {
                $cart = null;
            }

            return response()->json([
                'cart' => $cart
            ]);
        } catch (Exception $e) {
            if (config('app.env') !== 'production') {
                return $e->getMessage();
            } else {
                Log::error($e->getMessage());
                return response()->json([
                    'error' => 'This request failed successfully in cart show.'
                ], 500);
            }
        }
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

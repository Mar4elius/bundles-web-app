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
// Requests
use App\Http\Requests\Api\Carts\StoreCartBundleRequest;
use App\Http\Requests\Api\Carts\UpdateCartBundleRequest;

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
     * @param  App\Http\Requests\Api\Carts\StoreCartBundleRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCartBundleRequest $request)
    {
        try {
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
        } catch (Exception $e) {
            if (config('app.env') !== 'production') {
                return $e->getMessage();
            } else {
                Log::error($e->getMessage());
                return response()->json([
                    'error' => 'This request failed successfully in cart bundle store.'
                ]);
            }
        }
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
     * @param  App\Http\Requests\Api\Carts\UpdateCartBundleRequest  $request
     * @param  App\Models\CartBundle $cart_bundle
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCartBundleRequest $request, CartBundle $cart_bundle)
    {
        // increment_qnt not always in the request. Need to check if it exist
        $increment_qnt = $request->increment_qnt ?? null;

        if (!is_null($increment_qnt)) {
            $cart_bundle->quantity = $increment_qnt ? $cart_bundle->quantity + 1 : $cart_bundle->quantity - 1;
        }

        $cart_bundle->save();

        $cart_bundle->load('products');

        return response()->json([
            'message'       => 'Bundle has been updated.',
            'cart_bundle'   => $cart_bundle
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\CartBundle $cart_bundle
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartBundle $cart_bundle)
    {
        try {
            // delete cart_bundle_product records
            $cart_bundle->products()->detach();
            $cart_bundle->delete();

            return response()->json([
                'message' => 'Bundle has been removed from the cart'
            ]);
        } catch (Exception $e) {
            if (config('app.env') !== 'production') {
                return $e->getMessage();
            } else {
                Log::error($e->getMessage());
                return response()->json([
                    'error' => 'This request failed successfully in cart bundle destroy.'
                ]);
            }
        }
    }
}

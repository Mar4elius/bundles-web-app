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
        // create cart
        $cart->sub_total = $request->cart_sub_total;
        $cart->save();

        return response()->json([
            'cart' => $cart->refresh(),
            'message' => 'Cart has been created.'
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
     * @param  App\Models\Cart $cart
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return response()->json([
            'message' => 'Cart has been deleted.'
        ]);
    }
}

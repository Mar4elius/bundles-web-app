<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

use Stripe\Stripe as Stripe;
use Stripe\PaymentIntent as PaymentIntent;

class StripeController extends Controller
{
    public function __construct()
    {
        $this->strip_key = config('services.stripe.sk_test');
    }

    /**
     * Create Stripe Payment Intent
     *
     * @return \Illuminate\Http\Response
     */
    //TODO: Must put a check if bundle belong to user
    public function create(Request $request)
    {
        Stripe::setApiKey($this->strip_key);
        $cart = Cart::find($request->cart_id);
        $cart->load(['cartBundles.products' => function ($q) {
            return $q->withPivot('quantity');
        }])->get();

        // get subtotal for the order
        $sub_total = $cart->cartBundles->reduce(function ($carry, $item) {
            return $carry + $item->price_per_bundle;
        });

        $payment_intent = PaymentIntent::create([
            'amount'    => $sub_total,
            'currency'  => 'cad'
        ]);

        return response()->json([
            'clientSecret' => $payment_intent->client_secret
        ]);
    }

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
        //
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

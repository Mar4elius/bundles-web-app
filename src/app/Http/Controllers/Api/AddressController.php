<?php

namespace App\Http\Controllers\Api;
// Support
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
// Models
use App\Models\Address;
use App\Models\Province;
use App\Models\User;
// Requests
use App\Http\Requests\Api\Address\StoreAddressRequest;

class AddressController extends Controller
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
     * @param  App\Http\Requests\Api\Address\StoreAddressRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAddressRequest $request)
    {
        try {
            $data = $request->all();
            $user = User::find($data['user_id']);

            $address = new Address();
            $address->storeAddress($data);

            // create shipping address;
            $user->addresses()->attach($address->id, [
                'is_active' => true,
                'is_billing' => $data['is_billing'],
                'is_shipping' => !$data['is_billing']
            ]);

            // addresses are the same call create billing
            if ($data['is_billing_and_shipping_same']) {
                $user->addresses()->attach($address->id, [
                    'is_active' => true,
                    'is_billing' => true,
                    'is_shipping' => false
                ]);
            }

            return response()->json([
                'message' => 'Address has been saved.'
            ]);
        } catch (Exception $e) {
            if (config('app.env') !== 'production') {
                return $e->getMessage();
            } else {
                Log::error($e->getMessage());
                return response()->json([
                    'error' => 'This request failed successfully in address store.'
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
     * @param  \Illuminate\Http\Request  $request
     * @param  use App\Models\Address $address
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        try {
            $data = $request->all();
            $user = User::find(11);

            // if billing and shipping are the same - update the main address
            if ($data['is_billing_and_shipping_same'] && !$data['is_billing']) {
                $address->storeAddress($data);

                // find billing address and delete it because now they are the same
                $billing_address = $user->addresses()
                    ->wherePivot('is_billing', true)
                    ->wherePivot('is_active', true)
                    ->first();

                if ($billing_address) {
                    //Find old billing address, because now they are the same and delete it.
                    $user->addresses()->detach($billing_address->id);
                    // Delete address from the address table
                    Address::whereId($billing_address->id)->delete();
                }

                $user->addresses()->attach([$address->id => [
                    'is_active' => true,
                    'is_billing' => true,
                    'is_shipping' => false
                ]]);
            } else {
                // addresses are different
                // update shipping address
                if (!$data['is_billing']) {
                    $address->storeAddress($data);
                } else if ($data['is_billing']) {
                    // update billing address
                    // find all active addresses for this user
                    $addresses = $user->addresses()
                        ->wherePivot('is_active', true)
                        ->get();
                    // check if they used to use the same address
                    $used_to_be_same = $addresses->every(function ($value) use ($address) {
                        return $value->pivot->address_id === $address->id;
                    });

                    if ($used_to_be_same) {
                        // create new address in Addresses table
                        $new_address = new Address();
                        $new_address->storeAddress($data);
                        // update pivot billing address and connect it to new address
                        $user->addresses()->wherePivot('is_billing', true)->updateExistingPivot($address->id, [
                            'address_id' => $new_address->id,
                            'is_active' => true,
                            'is_billing' => true,
                            'is_shipping' => false
                        ]);
                    }
                }
            }
            return response()->json([
                'message' => 'Address has been updated.'
            ]);
        } catch (Exception $e) {
        }
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

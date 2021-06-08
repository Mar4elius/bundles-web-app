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
        // try {
        $data = $request->all();
        $user = User::find($data['id']);

        $address = new Address();
        $address->user()->associate(($user));
        $address->address = $data['address'] ?: null;
        $address->apartment = $data['apartment'] ?: null;
        $address->city = $data['city'] ?: null;

        if (isset($data['province_id'])) {
            $province = Province::find($data['province_id']);
            $address->province()->associate($province);
        }
        $address->postal_code = $data['postal_code'] ?: null;
        $address->phone = $data['phone'] ?: null;
        $address->is_active = true;

        $address->save();

        return response()->json([
            'message' => 'Address has been saved.'
        ]);
        // } catch (Exception $e) {
        //     if (config('app.env') !== 'production') {
        //         return $e->getMessage();
        //     } else {
        //         Log::error($e->getMessage());
        //         return response()->json([
        //             'error' => 'This request failed successfully in address store.'
        //         ]);
        //     }
        // }
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

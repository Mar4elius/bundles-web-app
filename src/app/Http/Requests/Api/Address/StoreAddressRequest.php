<?php

namespace App\Http\Requests\Api\Address;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address' => 'required|string',
            'province_id' => 'required|numeric',
            'city' => 'required|string',
            'postal_code' => 'required|string|min:7',
            'phone' => 'required|string|min:16'
        ];
    }
}

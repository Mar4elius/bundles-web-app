<?php

namespace App\Http\Requests\Api\Carts;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartBundleRequest extends FormRequest
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
            'cart_id'       => 'required|numeric',
            'name'          => 'required|string',
            'quantity'      => 'required|numeric',
            'price'         => 'required|numeric',
            'image_path'    => 'required|string',
            'products'      => 'required|array'
        ];
    }
}

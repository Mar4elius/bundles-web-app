<?php

namespace App\Http\Requests\Api\Bundles;

use Illuminate\Foundation\Http\FormRequest;

class GetAdditionalBundlesRequest extends FormRequest
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
            'quantity'      => 'numeric|nullable',
            'sort_by'       => 'string|nullable',
            'order'         => 'string|nullable',
            'bundle'        => 'nullable'
        ];
    }
}

<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
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
            'first_name' => 'required_if:is_user_profile_update,true|string',
            'last_name' => 'required_if:is_user_profile_update,true|string',
            'email' => 'required_if:is_user_profile_update,true|email|unique:users,email,' . $this->request->get(
                'id'
            )
        ];
    }
}

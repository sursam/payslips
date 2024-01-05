<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
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
            'first_name'     =>  'required|string',
            'last_name'      =>  'required|string',
            'email'          =>  'required|email|unique:users',
            'mobile_number'  =>  'required|numeric|unique:users',
            'password'       => 'required|string',
            'confirm_password' => 'required|string|same:password',
            'organization_name' => 'required',
            'designation' => 'required',
            'seller_image'  => 'sometimes|file|mimes:jpg,png,jpeg',
        ];
    }
}

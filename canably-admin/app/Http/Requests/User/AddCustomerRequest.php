<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AddCustomerRequest extends FormRequest
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
            'address'        =>  'sometimes|string|min:3|nullable',
            'country'        =>  'sometimes|string|nullable',
            'state'          =>  'sometimes|string|nullable',
            'city'           =>  'sometimes|string|nullable',
            'zipcode'        =>  'sometimes|numeric|nullable',
            'customer_image'  => 'sometimes|file|mimes:jpg,png,jpeg',
        ];
    }
}

<?php

namespace App\Http\Requests\Coupon;

use App\Rules\MaxValueWhen;
use Illuminate\Foundation\Http\FormRequest;

class AddCouponRequest extends FormRequest
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
            'code'              =>  'required|string|unique:coupons,code',
            'title'              =>  'required|string|unique:coupons,title',
            'coupon_type'       =>  'required',
            'coupon_discount'   =>  ['required','numeric',new MaxValueWhen(99.99,'coupon_type','%')],
            'usage_per_user'    =>  'required|numeric',
            'usage_of_coupon'   =>  'required|numeric',
            'started_at'        =>  'required|date|after_or_equal:today',
            'ended_at'          =>  'required|date|after_or_equal:started_at'
        ];
    }
}

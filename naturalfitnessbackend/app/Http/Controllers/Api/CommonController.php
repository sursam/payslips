<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class CommonController extends BaseController
{
    protected $rule= 'sometimes|array';

    public function __construct($rule){
        $this->rule= $rule;
    }

    public function getProducts(Request $request){
        $validator = Validator::make($request->all(), [
            'is_popular'=> 'sometimes|boolean',
            'is_featured'=> 'sometimes|boolean',
            'category'=> $this->rule,
            'category.*'=> 'exists:categories,uuid',
            'brand'=> $this->rule,
            'brand.*'=> 'exists:brands,uuid',
            'types'=> $this->rule,
            'types.*'=> 'exists:tags,uuid',
        ]);
        if($validator->fails()) return $this->responseJson(false, 422, $validator->errors()->all(), "");
        try {
            $filterConditions= collect([]);
            if($request->has('is_popular')){
                $filterConditions= $filterConditions->merge($request->only('is_popular'));
            }
            if($request->has('is_featured')){
                $filterConditions= $filterConditions->merge($request->only('is_featured'));
            }
            if($request->has('category')){
                $filterConditions= $filterConditions->merge($request->only('category'));
            }

            $filterConditions= $filterConditions->toArray();
            return $this->responseJson(true,200,'Products Found Successfully',[]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
        // return $this->responseJson(true,200,'No Products Found',[]);
    }
}

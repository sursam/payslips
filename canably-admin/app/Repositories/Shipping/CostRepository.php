<?php

namespace App\Repositories\Shipping;

use App\Contracts\Shipping\CostContract;
use App\Models\ShippingCost;
use App\Repositories\BaseRepository;

/**
 * Class StoreRepository
 *
 * @package \App\Repositories
 */
class CostRepository extends BaseRepository implements CostContract
{
    public function __construct(ShippingCost $model)
    {
        parent::__construct($model);
        $this->model= $model;
    }

    public function listCosts(array $filterConditions, string $orderBy='id', string $sortBy='asc',$limit=null){
        $model = $this->model;
        if(!is_null($filterConditions)){
            $model= $model->where($filterConditions);
        }
        $model= $model->orderBy($orderBy,$sortBy);
        if($limit){
            return $model->paginate($limit);
        }
        return $model->get();
    }

    public function addShippingCosts(array $attributes)
    {
        foreach ($attributes['shipping'] as $key => $value) {
            if($value['pincode']){
                $pincodes= explode(',',$value['pincode']);
            }
            if(isset($pincodes)){
                foreach ($pincodes as $pincode) {
                    if(!empty($pincode)){
                        $this->create([
                            'country_id' => $value['country'],
                            'state_id' => $value['state'],
                            'city_id' => $value['city'],
                            'cost'      => $value['cost'],
                            'pincode' => $pincode
                        ]);
                    }
                }
                unset($pincodes);
            }else{
                $this->create([
                    'country_id' => $value['country'],
                    'state_id' => $value['state'],
                    'city_id' => $value['city'],
                    'cost'      => $value['cost'],
                ]);
            }
        }
        return true;
    }
}

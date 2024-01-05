<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\BaseRepository;
use App\Contracts\Order\OrderContract;
use App\Models\OrderAddress;
use App\Models\OrderDetail;
use App\Models\Transaction;

/**
 * Class MeuRepository
 *
 * @package \App\Repositories
 */

class OrderRepository extends BaseRepository implements OrderContract
{
    protected $model;
    protected $transactionModel;
    protected $orderDetailModel;
    protected $orderAddressModel;

    public function __construct(Order $model,Transaction $transactionModel,OrderDetail $orderDetailModel,OrderAddress $orderAddressModel){
        parent::__construct($model);
        $this->model= $model;
        $this->transactionModel= $transactionModel;
        $this->orderDetailModel= $orderDetailModel;
        $this->orderAddressModel= $orderAddressModel;
    }

    public function getOrderDataByType(array $attributes,$limit=''){
        $id= auth()->user()->id;
        switch ($attributes['type']) {
            case 'completed':
                $orders = $this->model->where(['user_id'=>$id,'delivery_status'=>1]);
                break;
            case 'cancelled':
                $orders = $this->model->where(['user_id'=>$id,'delivery_status'=>2]);
                break;
            default:
                $orders = $this->model->where(['user_id'=>$id]);
                break;
        }
        if($limit!=''){
            return $orders->paginate($limit);
        }
        return $orders->get();
    }
}

<?php

namespace App\Services\Order;

use App\Contracts\Order\OrderContract;

class OrderService
{
    protected $orderRepository;

    public function __construct(OrderContract $orderRepository){
        $this->orderRepository = $orderRepository;
    }

    public function getOrders(){
        return $this->orderRepository->all();
    }

    public function findOrder(int $id){
        return $this->orderRepository->find($id);
    }

    public function getOrdersByStatus(array $type,$paginate=''){
        return $this->orderRepository->getOrderDataByType($type,$paginate);
    }

    public function getOrdersById(int $id){
        return $this->orderRepository->find($id);
    }

    public function updateOrder(array $attributes,$id){
        return $this->orderRepository->update($attributes,$id);
    }

}

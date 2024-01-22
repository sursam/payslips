<?php

namespace App\Services\Subscription;

use App\Contracts\Subscription\SubscriptionContract;

class SubscriptionService
{

    public function __construct(protected SubscriptionContract $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function getList($start, $limit, $order, $dir, $search=null)
    {
        return $this->subscriptionRepository->getList($start, $limit, $order, $dir, $search);
    }

    public function getTotalData($search=null)
    {
        return $this->subscriptionRepository->getTotalData($search);
    }


    public function listPlans(string $orderBy = 'id', string $sortBy = 'asc'){
        return $this->subscriptionRepository->all('*',$orderBy,$sortBy);
    }
    public function find(int $id){
        return $this->subscriptionRepository->find($id);
    }

    public function createOrupdatePlan(array $attributes,$id=null){
        if(!is_null($id)){
            return $this->subscriptionRepository->updatePlan($attributes,$id);
        }
        return $this->subscriptionRepository->createPlan($attributes);
    }

    public function addSubscription(array $attributes,int $id){
        return $this->subscriptionRepository->makeSubscription($attributes,$id);
    }

    public function updateSubscription(array $attributes,int $id){
        return $this->subscriptionRepository->update($attributes,$id);
    }

    public function deleteSubscription(int $id){
        return $this->subscriptionRepository->delete($id);
    }
}

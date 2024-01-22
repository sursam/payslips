<?php

namespace App\Services\Vehicle;

use App\Contracts\Vehicle\VehicleContract;

class VehicleService
{
    protected $vehicleRepository;
    public function __construct(VehicleContract $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }
    public function listVehicles(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
         return $this->vehicleRepository->listVehicles($filterConditions,$orderBy,$sortBy,$limit);
     }
    public function getTotalData($search=null){
        return $this->vehicleRepository->getTotalData($search);
    }
    public function getListofVehicles($start, $limit, $order, $dir, $search=null){
        return $this->vehicleRepository->getList($start, $limit, $order, $dir, $search);
    }
    public function findVehicleById($id){
        return $this->vehicleRepository->findVehicleById($id);
    }
    public function updateVehicle(array $attributes,$id){
        return $this->vehicleRepository->update($attributes,$id);
    }
    public function createOrUpdateVehicle(array $attributes,$id= null){
        if(is_null($id)){
            return $this->vehicleRepository->createVehicle($attributes);
        }else{
            return $this->vehicleRepository->updateVehicle($attributes,$id);
        }
    }
    public function deleteVehicle(int $id){
        return $this->vehicleRepository->deleteVehicle($id);
    }

}

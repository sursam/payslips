<?php

namespace App\Services\Zone;

use App\Contracts\Zone\ZoneContract;

class ZoneService
{
    protected $zoneRepository;
    public function __construct(ZoneContract $zoneRepository)
    {
        $this->zoneRepository= $zoneRepository;
    }
    public function listZones(array $filterConditions,string $orderBy='id',$sortBy='asc',$limit= null,$inRandomOrder= false){
         return $this->zoneRepository->listZones($filterConditions,$orderBy,$sortBy,$limit);
     }

     public function getTotalData($search=null){
         return $this->zoneRepository->getTotalData($search);
     }

     public function getListofZones($start, $limit, $order, $dir, $search=null){
         return $this->zoneRepository->getList($start, $limit, $order, $dir, $search);
     }
     public function findZoneById($id){
         return $this->zoneRepository->find($id);
     }

     public function updateZone(array $attributes,$id){
         return $this->zoneRepository->update($attributes,$id);
     }

     public function createOrUpdateZone(array $attributes,$id= null){
         if(is_null($id)){
             return $this->zoneRepository->createZone($attributes);
         }else{
             return $this->zoneRepository->updateZone($attributes,$id);
         }
     }

     public function deleteZone(int $id){
         return $this->zoneRepository->delete($id);
     }
}

<?php

namespace App\Repositories\Zone;

use App\Models\Site\Zone;
use App\Contracts\Zone\ZoneContract;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ZoneRepository extends BaseRepository implements ZoneContract
{
    protected $model;
    public function __construct(Zone $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * List of all zones
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listZones($filterConditions,string $order = 'id', string $sort = 'desc',$limit= null,$inRandomOrder= false){
        $zones= $this->all();
        if(!is_null($limit)){
            return $zones->paginate($limit);
        }
        return $zones;
    }


    /**
     * Find a zone with id
     *
     *
     */
    public function findZoneById(int $id)
    {
        try
        {
            return $this->findOneBy(['id' => $id]);

        }
        catch (ModelNotFoundException $exception)
        {
            throw new ModelNotFoundException($exception);
        }
    }

    public function findZone($params)
    {
        $query = $this->model->where([
            ['status', true]
        ]);
        return $query->first();
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function createZone($attributes)
    {
        $isZoneCreated= $this->create([
            'name' => $attributes['name']
        ]);
        if ($isZoneCreated) {
            foreach (json_decode($attributes['coordinates'], true) as $postcode => $value) {
                $isZoneCreated->ZonePostcodes()->create([
                    'postcode'=> $postcode,
                    'latitude' => $value['lat'],
                    'longitude' => $value['lng'],
                    'place_id' => $value['place_id'],
                ]);
            }
        }
        return $isZoneCreated;
    }
    public function updateZone($attributes,$id)
    {
        $isZone= $this->find($id);
        $isZoneUpdated= $this->update([
            'name' => $attributes['name']
        ],$id);
        if ($isZoneUpdated) {
            $isZone->ZonePostcodes()->forceDelete();
            foreach (json_decode($attributes['coordinates'], true) as $postcode => $value) {
                $isZone->ZonePostcodes()->create([
                    'postcode'=> $postcode,
                    'latitude' => $value['lat'],
                    'longitude' => $value['lng'],
                    'place_id' => $value['place_id']
                ]);
            }
        }
        return $isZoneUpdated;
    }

    /**
     * Delete a zone
     *
     * @param $id
     * @return bool|mixed
     */
    public function deleteZone($id)
    {
        $zone = $this->findZoneById($id);
        $zone?->delete();

        return $zone ?? false;
    }

    /**
     * Update a zone's status
     *
     * @param array $params
     * @return mixed
     */
    public function updateZoneStatus(array $params)
    {
        $zone = $this->findZoneById($params['id']);
        $collection = collect($params)->except('_token');
        $zone->status = $collection['check_status'];
        $zone->update();
        return $zone;
    }

    /**
     * Get count of total zones
     *
     * @param null $search
     * @return mixed
     */
    public function getTotalData($search=null)
    {
        $query = $this->model;
        if($search) {
            $query = $query->where('name','LIKE',"%{$search}%");
        }

        return $query->count();
    }

    /**
     * Get list of zones for datatable
     *
     * @param $start
     * @param $limit
     * @param $order
     * @param $dir
     * @param null $search
     * @return mixed
     */
    public function getList($start, $limit, $order, $dir, $search = null)
    {
        $query = $this->model;

        if($search) {
            $query = $query->where('name','LIKE',"%{$search}%");
        }

        return $query->offset($start)->limit($limit)->orderBy($order, $dir)->get();
    }
}

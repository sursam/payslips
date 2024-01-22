<?php

namespace App\Repositories\Vehicle;

use App\Traits\UploadAble;
use App\Repositories\BaseRepository;
use App\Contracts\Vehicle\VehicleContract;
use App\Models\Site\Media;
use App\Models\Vehicle\Vehicle;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VehicleRepository extends BaseRepository implements VehicleContract
{
    use UploadAble;
    protected $model;
    public function __construct(Vehicle $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listVehicles($filterConditions,string $order = 'id', string $sort = 'desc',$limit= null,$inRandomOrder= false){
        $vehicles= $this->all();
        if(!is_null($limit)){
            return $vehicles->paginate($limit);
        }
        return $vehicles;
    }
    public function findVehicleById(int $id)
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
    public function findVehicle($params)
    {
        $query = $this->model->where([
            ['status', true]
        ]);
        return $query->first();
    }
    public function getTotalData($search=null)
    {
        $query = $this->model;
        if($search) {
            $query = $query->where('registration_number','LIKE',"%{$search}%")
            ->orWhereHas('companies', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            })
            ->orWhereHas('vehicle_types', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        return $query->count();
    }
    public function getList($start, $limit, $order, $dir, $search = null)
    {
        $query = $this->model;

        if($search) {
            $query = $query->where('registration_number','LIKE',"%{$search}%")
            ->orWhereHas('companies', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            })
            ->orWhereHas('vehicle_types', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        return $query->offset($start)->limit($limit)->orderBy($order, $dir)->get();
    }
    public function createVehicle(array $attributes)
    {
        // $company_id = $attributes['company_id'] ? uuidtoid($attributes['company_id'], 'companies') : null;
        $category_id = $attributes['category_id'] ? uuidtoid($attributes['category_id'], 'categories') : null;
        $sub_category_id = $attributes['sub_category_id'] ? uuidtoid($attributes['sub_category_id'], 'categories') : null;
        $body_type_id = $attributes['body_type_id'] ? uuidtoid($attributes['body_type_id'], 'categories') : null;
        $user_id = $attributes['user_id'] ? uuidtoid($attributes['user_id'], 'users') : null;
        $helper_count = isset($attributes['helper_count']) ? $attributes['helper_count'] : 0;
        $vehicle = $this->create([
            "registration_number" => $attributes['registration_number'],
            // "company_id" => $company_id,
            "category_id" => $category_id,
            "sub_category_id" => $sub_category_id,
            "body_type_id" => $body_type_id,
            "user_id" => $user_id,
            "helper_count" => $helper_count,
            "is_active" => true,
        ]);
        if (isset($attributes['rc_front'])) {
            $fileName = uniqid() . '.' . $attributes['rc_front']->getClientOriginalExtension();
            $isFileUploaded = $this->uploadOne($attributes['rc_front'], config('constants.SITE_VEHICLE_IMAGE_UPLOAD_PATH'), $fileName, 'public');
            if ($isFileUploaded) {
                $vehicle->image()->create([
                    "user_id" => $user_id,
                    'mediaable_type' => get_class($vehicle),
                    'mediaable_id' => $vehicle->id,
                    'media_type' => 'rc_front',
                    'file' => $fileName,
                    'is_profile_picture' => false
                ]);
            }
        }
        if (isset($attributes['rc_back'])) {
            $fileName = uniqid() . '.' . $attributes['rc_back']->getClientOriginalExtension();
            $isFileUploaded = $this->uploadOne($attributes['rc_back'], config('constants.SITE_VEHICLE_IMAGE_UPLOAD_PATH'), $fileName, 'public');
            if ($isFileUploaded) {
                $vehicle->image()->create([
                    "user_id" => $user_id,
                    'mediaable_type' => get_class($vehicle),
                    'mediaable_id' => $vehicle->id,
                    'media_type' => 'rc_back',
                    'file' => $fileName,
                    'is_profile_picture' => false
                ]);
            }
        }
        if (isset($attributes['vehicle_image'])) {
            $fileName = uniqid() . '.' . $attributes['vehicle_image']->getClientOriginalExtension();
            $isFileUploaded = $this->uploadOne($attributes['vehicle_image'], config('constants.SITE_VEHICLE_IMAGE_UPLOAD_PATH'), $fileName, 'public');
            if ($isFileUploaded) {
                $vehicle->image()->create([
                    "user_id" => $user_id,
                    'mediaable_type' => get_class($vehicle),
                    'mediaable_id' => $vehicle->id,
                    'media_type' => 'vehicle_image',
                    'file' => $fileName,
                    'is_profile_picture' => false
                ]);
            }
        }
        return $vehicle;
    }
    public function updateVehicle($attributes, $id)
    {
        // dd($attributes);
        $isVehicle = $this->find($id);
        $category_id = $attributes['category_id'] ? uuidtoid($attributes['category_id'], 'categories') : null;
        if(isset($attributes['sub_category_id'])){
            $sub_category_id = uuidtoid($attributes['sub_category_id'], 'categories');
        }
        if(isset($attributes['body_type_id'])){
            $body_type_id = uuidtoid($attributes['body_type_id'], 'categories');
        }
        $user_id = uuidtoid($attributes['user_id'], 'users');
        $helper_count = isset($attributes['helper_count']) ? $attributes['helper_count'] : 0;
        $isVehicleUpdated = $this->update([
            "registration_number" => $attributes['registration_number'],
            // "company_id" => $company_id,
            "category_id" => $category_id,
            "sub_category_id" => $sub_category_id ?? null,
            "body_type_id" => $body_type_id ?? null,
            "user_id" => $user_id,
            "helper_count" => $helper_count,
            "is_active" => true,
        ], $id);
        if($isVehicleUpdated){
            if (isset($attributes['rc_front'])) {
                $fileName = uniqid() . '.' . $attributes['rc_front']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['rc_front'], config('constants.SITE_VEHICLE_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isVehicle->image()->updateOrCreate(['user_id' => $user_id,'media_type'=>'rc_front'], [
                        'user_id' => $user_id,
                        'media_type' => 'rc_front',
                        'file' => $fileName,
                        'alt_text' => $attributes['alt_text'] ?? null,
                        'is_profile_picture' => false,
                    ]);
                }
            }
            if (isset($attributes['rc_back'])) {
                $fileName = uniqid() . '.' . $attributes['rc_back']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['rc_back'], config('constants.SITE_VEHICLE_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isVehicle->image()->updateOrCreate(['user_id' => $user_id,'media_type'=>'rc_back'], [
                        'user_id' => $user_id,
                        'media_type' => 'rc_back',
                        'file' => $fileName,
                        'alt_text' => $attributes['alt_text'] ?? null,
                        'is_profile_picture' => false,
                    ]);
                }
            }
            if (isset($attributes['vehicle_image'])) {
                $fileName = uniqid() . '.' . $attributes['vehicle_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['vehicle_image'], config('constants.SITE_VEHICLE_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isVehicle->image()->updateOrCreate(['user_id' => $user_id,'media_type'=>'vehicle_image'], [
                        'user_id' => $user_id,
                        'media_type' => 'vehicle_image',
                        'file' => $fileName,
                        'alt_text' => $attributes['alt_text'] ?? null,
                        'is_profile_picture' => false,
                    ]);
                }
            }
        }

        return $isVehicleUpdated;
    }
    public function deleteVehicle($id)
    {
        $vehicle = $this->findVehicleById($id);

        return $vehicle ?? false;
    }
    public function updateVehicleStatus(array $params)
    {
        $vehicle = $this->findVehicleById($params['id']);
        $collection = collect($params)->except('_token');
        $vehicle->status = $collection['check_status'];
        $vehicle->update();
        return $vehicle;
    }

}

<?php

namespace App\Repositories\Company;

use App\Models\Company\Company;
use App\Traits\UploadAble;
use App\Contracts\Company\CompanyContract;
use App\Repositories\BaseRepository;

/**
 * Class CompanyRepository
 *
 * @package \App\Repositories
 */
class CompanyRepository extends BaseRepository implements CompanyContract
{
    use UploadAble;
    /**
     * CompanyRepository constructor
     *
     * @param Company $model
     */
    public function __construct(Company $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * List of all companies
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listCompanies($filterConditions, string $order = 'id', string $sort = 'desc', $limit = null, $inRandomOrder = false)
    {
        $query =  $this->model;
        if (!is_null($filterConditions)) {
            $query = $query->where($filterConditions);
        }
        if ($inRandomOrder) {
            $query = $query->inRandomOrder();
        } else {
            $query = $query->orderBy($order, $sort);
        }
        if (!is_null($limit)) {
            return $query->paginate($limit);
        }
        return $query->get();
    }





    public function findCompanyByCountry($slug)
    {
        return $this->model->whereHas('country', function ($q) use ($slug) {
            $q->where('slug', $slug);
        });
    }


    /**
     * Create a company
     *
     * @param array $params
     * @return Company|mixed
     */
    public function createCompany(array $attributes)
    {
        $isCompanyCreated = $this->create($attributes);
        if ($isCompanyCreated && isset($attributes['company_logo'])) {
            $fileName = uniqid() . '.' . $attributes['company_logo']->getClientOriginalExtension();
            $isFileUploaded = $this->uploadOne($attributes['company_logo'], config('constants.SITE_COMPANY_IMAGE_UPLOAD_PATH'), $fileName, 'public');
            if ($isFileUploaded) {
                $isCompanyRelatedMediaCreated = $isCompanyCreated->medias()->create([
                    'user_id' => auth()->user()->id,
                    'media_type' => 'logo',
                    'file' => $fileName,
                    'is_profile_picture' => false
                ]);
            }
        }
        return $isCompanyCreated;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCompany($attributes, $id)
    {
        $isCompany = $this->find($id);
        $isCompanyUpdated = $this->update($attributes, $id);

        if ($isCompanyUpdated) {
            if (isset($attributes['company_logo'])) {
                $fileName = uniqid() . '.' . $attributes['company_logo']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['company_logo'], config('constants.SITE_COMPANY_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isCompany->medias()->where('media_type', 'logo')->delete();
                    $isCompany->medias()->create([
                        'user_id' => auth()->user()->id,
                        'media_type' => 'logo',
                        'file' => $fileName,
                        'is_profile_picture' => false
                    ]);
                }
            }
            if (isset($attributes['country_id'])) {
                $isCompany->locations()->forceDelete();
                $isCompany->locations()->create([
                    'country_id' => $attributes['country_id'],
                    'state_id' => $attributes['state_id'],
                    'city_id' => $attributes['city_id'] ?? null,
                    'zipcode' => $attributes['zipcode'],
                    'street_address' => $attributes['street_address'] ?? ''
                ]);
            }
        }
        return $isCompanyUpdated;
    }


    /**
     * Get count of total companies
     *
     * @param null $search
     * @return mixed
     */
    public function getTotalData($search = null)
    {
        $query = $this->model;
        if ($search) {
            $query = $query->where('name', 'LIKE', "%{$search}%");
        }

        return $query->count();
    }

    /**
     * Get list of companies for datatable
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

        if ($search) {
            $query = $query = $query->where('name', 'LIKE', "%{$search}%");
        }

        return $query->offset($start)->limit($limit)->orderBy($order, $dir)->get();
    }

    public function createLocation(array $attributes, $id)
    {
        return $this->model->find($id)->locations()->updateOrCreate([
            'city_id' => $attributes['city_id'],
            'country_id' => $attributes['country_id'],
            'zipcode' => $attributes['zipcode'],
            'street_address' => $attributes['street_address']
        ]);
    }
}

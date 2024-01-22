<?php

namespace App\Repositories\Fare;

use Carbon\Carbon;
use App\Models\Site\Seo;
use App\Traits\UploadAble;
use App\Models\Site\Category;
use App\Models\Fare\HelperFare;
use App\Repositories\BaseRepository;
use App\Contracts\Fare\HelperFareContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HelperFareRepository extends BaseRepository implements HelperFareContract
{
    use UploadAble;


    protected $model, $seoModel;
    /**
     * PageRepository constructor
     *
     * @param HelperFare $model
     */
    /**
     * SeoRepository constructor
     *
     * @param Seo $seoModel
     */
    public function __construct(HelperFare $model, Seo $seoModel)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->seoModel = $seoModel;
    }

    /**
     * List of all fares
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listHelperFares($filterConditions, string $order = 'id', string $sort = 'desc', $limit = null, $inRandomOrder = false)
    {
        $helperFares = $this->all();
        if (!is_null($limit)) {
            return $helperFares->paginate($limit);
        }
        return $helperFares;
    }


    /**
     * Find a fare with id
     *
     *
     */
    public function findHelperFareById(int $id)
    {
        try {
            return $this->findOneBy(['id' => $id]);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception);
        }
    }

    /**
     * Find a fare by it's slug
     *
     * @param $slug
     * @return mixed
     */
    public function findHelperFareBySlug($slug)
    {
        return $this->model::where([
            ['slug', '=', $slug],
            ['is_active', '=', 1],
        ])->first();
    }

    public function findHelperFareByCountry($slug)
    {
        return $this->model::where([
            ['country', $slug],
            ['page_type', 'Location']
        ])
            ->whereNull('city')
            ->whereNull('category')
            ->first();
    }

    public function findHelperFare($params)
    {

        /* $query = $this->model::where([
            ['country', $params['country']],
            ['page_type', 'Location']
            ]); */
        $query = $this->model->where([
            ['status', true]
        ]);

        if ($params->has('category') && !is_null($params['category'])) {
            $query->where('page_type', 'Categories');
        } else {
            $query->where('page_type', 'Location');
        }

        if ($params->has('country') && !is_null($params['country'])) {
            $query->where('country', $params['country']);

            if (is_null($params['city']) && is_null($params['category'])) {
                $query->where('city', null)->where('category', null);
            }
        }
        if ($params->has('city') && !is_null($params['city'])) {

            $query->Where(function ($query) use ($params) {
                $query->where('city', $params['city']);
            });

            if (is_null($params['category'])) {
                $query->where('category', null);
            }
        }
        if ($params->has('category') && !is_null($params['category'])) {
            $query->Where(function ($query) use ($params) {
                $query->where('category', $params['category']);
            });
        }
        return $query->first();
    }

    /**
     * Create a page
     *
     * @param array $params
     * @return HelperFare|mixed
     */
    public function createHelperFare(array $params)
    {
        $collection = collect($params);
        $helperFare = $this->create([
            'count' => $collection['count'],
            'amount' => $collection['amount'] ?? 0,
            'is_active' => true
        ]);
        return $helperFare;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateHelperFare($attributes, $id)
    {
        $fareData = $this->find($id);
        $isHelperFareUpdated = $this->update([
                'count' => $collection['count'],
                'amount' => $attributes['edit_amount'] ?? 0
            ], $id);
        return $isHelperFareUpdated;
    }

    /**
     * Delete a fare
     *
     * @param $id
     * @return bool|mixed
     */
    public function deleteHelperFare($id)
    {
        $helperFare = $this->findHelperFareById($id);
        ## Delete fare seo
        $helperFare->seo?->delete();
        $helperFare?->delete();

        return $helperFare ?? false;
    }

    /**
     * Update a fare's status
     *
     * @param array $params
     * @return mixed
     */
    public function updateHelperFareStatus(array $params)
    {
        $helperFares = $this->findHelperFareById($params['id']);
        $collection = collect($params)->except('_token');
        $helperFares->status = $collection['check_status'];
        $helperFares->update();
        return $helperFares;
    }

    /**
     * Get count of total pages
     *
     * @param null $search
     * @return mixed
     */
    public function getTotalData($search = null)
    {
        $query = $this->model;
        if($search) {
            $query = $query->where('title','LIKE',"%{$search}%")
                           ->orWhere('slug', 'LIKE',"%{$search}%")
                           ->orWhere('name','LIKE',"%{$search}%");
        }

        return $query->count();
    }

    /**
     * Get list of pages for datatable
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
            $query = $query->where('title', 'LIKE', "%{$search}%")
                ->orWhere('slug', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%");
        }

        return $query->offset($start)->limit($limit)->orderBy($order, $dir)->get();
    }

    public function getCategories()
    {
        return Category::all();
    }
}

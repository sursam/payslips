<?php

namespace App\Repositories\Fare;

use Carbon\Carbon;
use App\Models\Site\Seo;
use App\Models\Fare\Fare;
use App\Traits\UploadAble;
use App\Models\Site\Category;
use App\Contracts\Fare\FareContract;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FareRepository extends BaseRepository implements FareContract
{
    use UploadAble;


    protected $model, $seoModel;
    /**
     * PageRepository constructor
     *
     * @param Fare $model
     */
    /**
     * SeoRepository constructor
     *
     * @param Seo $seoModel
     */
    public function __construct(Fare $model, Seo $seoModel)
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
    public function listFares($filterConditions, string $order = 'id', string $sort = 'desc', $limit = null, $inRandomOrder = false)
    {
        $fares = $this->all();
        if (!is_null($limit)) {
            return $fares->paginate($limit);
        }
        return $fares;
    }


    /**
     * Find a fare with id
     *
     *
     */
    public function findFareById(int $id)
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
    public function findFareBySlug($slug)
    {
        return $this->model::where([
            ['slug', '=', $slug],
            ['is_active', '=', 1],
        ])->first();
    }

    public function findFareByCountry($slug)
    {
        return $this->model::where([
            ['country', $slug],
            ['page_type', 'Location']
        ])
            ->whereNull('city')
            ->whereNull('category')
            ->first();
    }

    public function findFare($params)
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
     * @return Fare|mixed
     */
    public function createFare(array $params)
    {
        $collection = collect($params);
        $carbonStartTime = Carbon::createFromFormat('h:i A', $collection['start_at']);
        // Format the time in 24-hour format
        $convertedStartTime = $carbonStartTime->format('H:i');
        $carbonEndTime = Carbon::createFromFormat('h:i A', $collection['end_at']);
        // Format the time in 24-hour format
        $convertedEndTime = $carbonEndTime->format('H:i');
        $fare = $this->create([
            'category_id' => $collection['category_id'],
            'start_at' => $convertedStartTime ?? '',
            'end_at' => $convertedEndTime ?? '',
            'amount' => $collection['amount'] ?? 0,
            'is_active' => true
        ]);
        // if ($fare) {
        //     $isRelatedSeoCreated = $fare->seo()->create([
        //         'body' => $collection['seo']
        //     ]);
        // }
        return $fare;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateFare($attributes, $id)
    {
        //$fareData = $this->find($id);
        $carbonEditStartTime = Carbon::createFromFormat('h:i A', $attributes['start_at']);
        $convertedEditStartTime = $carbonEditStartTime->format('H:i');
        $carbonEditEndTime = Carbon::createFromFormat('h:i A', $attributes['end_at']);
        $convertedEditEndTime = $carbonEditEndTime->format('H:i');
        $isFareUpdated = $this->update([
                'category_id' => $attributes['category_id'],
                'start_at' => $convertedEditStartTime ?? '',
                'end_at' => $convertedEditEndTime ?? '',
                'amount' => $attributes['amount'] ?? 0
            ], $id);
        // if ($isFareUpdated) {
        //     $isRelatedSeoUpdate = $fareData->seo()->updateOrCreate([
        //         'body' => $attributes['seo']
        //     ]);
        // }
        return $isFareUpdated;
    }

    /**
     * Delete a fare
     *
     * @param $id
     * @return bool|mixed
     */
    public function deleteFare($id)
    {
        $fare = $this->findFareById($id);
        ## Delete fare seo
        $fare->seo?->delete();
        $fare?->delete();

        return $fare ?? false;
    }

    /**
     * Update a fare's status
     *
     * @param array $params
     * @return mixed
     */
    public function updateFareStatus(array $params)
    {
        $fare = $this->findFareById($params['id']);
        $collection = collect($params)->except('_token');
        $fare->status = $collection['check_status'];
        $fare->update();
        return $fare;
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
    public function getFareBetweenTimes($time, $filterConditions = [])
    {
        $query = $this->model;
        $query = $query->where(function ($q) use ($time) {
            $q->where('start_at', '<=', $time);
            $q->where('end_at', '>=', $time);
        });
        if (!is_null($filterConditions)) {
            $query = $query->where($filterConditions);
        }
        return $query->first();
    }
}

<?php

namespace App\Repositories\Support;

use App\Traits\UploadAble;
use App\Models\Cms\Support;
use App\Repositories\BaseRepository;
use App\Contracts\Support\SupportContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SupportRepository extends BaseRepository implements SupportContract
{
    use UploadAble;

    protected $model;
    /**
     * BlogRepository constructor.
     * @param Support $model
     */
    public function __construct(Support $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listSupports($filterConditions, $orderBy = 'id', $sortBy = 'desc', $limit = null, $inRandomOrder = false)
    {
        $supports = $this->model;
        if (!is_null($filterConditions)) {
            $supports = $supports->where($filterConditions);
        }
        $supports = $supports->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $supports->paginate($limit);
        }
        return $supports->get();
    }
    public function createSupport($attributes)
    {
        return $this->create($attributes);
    }

    public function updateSupport($attributes, $id)
    {
        $supportData = $this->find($id);
        return $supportData->update($attributes);
    }
    /**
     * Find a Support with id
     *
     *
     */
    public function findSupportById(int $id)
    {
        try {
            return $this->findOneBy(['id' => $id]);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception);
        }
    }
}

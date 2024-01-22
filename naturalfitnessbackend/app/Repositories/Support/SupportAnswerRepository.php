<?php

namespace App\Repositories\Support;

use App\Traits\UploadAble;
use App\Models\Cms\SupportAnswer;
use App\Repositories\BaseRepository;
use App\Contracts\Support\SupportAnswerContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SupportAnswerRepository extends BaseRepository implements SupportAnswerContract
{
    use UploadAble;

    protected $model;
    /**
     * BlogRepository constructor.
     * @param SupportAnswer $model
     */
    public function __construct(SupportAnswer $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listSupportAnswers($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $supportAnswers = $this->model;
        if (!is_null($filterConditions)) {
            $supportAnswers = $supportAnswers->where($filterConditions);
        }
        $supportAnswers = $supportAnswers->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $supportAnswers->paginate($limit);
        }
        return $supportAnswers->get();
    }
    public function createSupportAnswer($attributes)
    {
        return $this->create($attributes);
    }

    public function updateSupportAnswer($attributes, $id)
    {
        $supportAnswerData = $this->find($id);
        return $supportAnswerData->update($attributes);
    }
    /**
     * Find a Support with id
     *
     *
     */
    public function findSupportAnswerById(int $id)
    {
        try {
            return $this->findOneBy(['id' => $id]);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception);
        }
    }
}

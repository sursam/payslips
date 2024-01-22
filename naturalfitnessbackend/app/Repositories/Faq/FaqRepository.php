<?php

namespace App\Repositories\Faq;

use App\Models\Cms\Faq;
use App\Traits\UploadAble;
use App\Contracts\Faq\FaqContract;
use App\Repositories\BaseRepository;

/**
 * Class BlogRepository
 *
 * @package \App\Repositories
 */
class FaqRepository extends BaseRepository implements FaqContract
{
    use UploadAble;

    protected $model;
    /**
     * BlogRepository constructor.
     * @param Faq $model
     */
    public function __construct(Faq $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listFaqs($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $faqs = $this->model;
        if (!is_null($filterConditions)) {
            $faqs = $faqs->where($filterConditions);
        }
        $faqs = $faqs->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $faqs->paginate($limit);
        }
        return $faqs->get();
    }
    public function createFaq($attributes)
    {
        return $this->create($attributes);
    }

    public function updateFaq($attributes, $id)
    {
        $faqData = $this->find($id);
        return $faqData->update($attributes);
    }
}

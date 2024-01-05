<?php

namespace App\Repositories\Transaction;

use App\Contracts\Transaction\TransactionContract;
use App\Models\Transaction;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;

/**
 * Class TransactionRepository
 *
 * @package \App\Repositories
 */
class TransactionRepository extends BaseRepository implements TransactionContract
{


    protected $model;
    /**
     * TransactionRepository constructor.
     * @param Transaction $model
     */
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function listTransactions($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        $transactions = $this->model;
        if (!is_null($filterConditions)) {
            $transactions = $transactions->where($filterConditions);
        }
        $transactions = $transactions->orderBy($orderBy, $sortBy);
        if (!is_null($limit)) {
            return $transactions->paginate($limit);
        }
        return $transactions->get();
    }

}

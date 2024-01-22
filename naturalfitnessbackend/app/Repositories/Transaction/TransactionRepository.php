<?php

namespace App\Repositories\Transaction;

use App\Contracts\Transaction\TransactionContract;
use App\Models\Site\Transaction;
use App\Repositories\BaseRepository;

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

    public function getTotalData($filterConditions, $search = null)
    {
        $query = $this->model->where($filterConditions);
        if($search) {
            $query = $query->where('transaction_no','LIKE',"%{$search}%")
                    ->orWhere('amount', 'LIKE',"%{$search}%")
                    ->orWhere('currency','LIKE',"%{$search}%")
                    ->orWhere('type','LIKE',"%{$search}%");
        }
        return $query->count();
    }
    public function getListofTransactions($filterConditions, $start, $limit, $order, $dir, $search = null)
    {
        $query = $this->model->where($filterConditions);
        if($search) {
            $query = $query->where(function($q)use($search){
                    $q->where('transaction_no','LIKE',"%{$search}%")
                        ->orWhere('amount', 'LIKE',"%{$search}%")
                        ->orWhere('currency','LIKE',"%{$search}%")
                        ->orWhere('type','LIKE',"%{$search}%");
            });
        }

        return $query->offset($start)->limit($limit)->orderBy($order, $dir)->get();
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

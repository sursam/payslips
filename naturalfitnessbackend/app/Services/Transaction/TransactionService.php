<?php

namespace App\Services\Transaction;

use App\Contracts\Transaction\TransactionContract;

class TransactionService
{
    protected $transactionRepository;

    public function __construct(TransactionContract $transactionRepository){
        $this->transactionRepository= $transactionRepository;
    }

    public function getTotalData(array $filterConditions, $search=null){
        return $this->transactionRepository->getTotalData($filterConditions, $search);
    }
    public function getListofTransactions(array $filterConditions,$start, $limit, $order, $dir, $search=null){
        return $this->transactionRepository->getListofTransactions($filterConditions,$start, $limit, $order, $dir, $search);
    }
    public function listTransactions(array $filterConditions, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->transactionRepository->listTransactions($filterConditions, $orderBy, $sortBy, $limit, $inRandomOrder);
    }
    public function findTransaction(string $uuid){
        $id= uuidtoid($uuid, 'transactions');
        return $this->transactionRepository->find($id);
    }

}

<?php

namespace App\Services\Transaction;

use App\Contracts\Transaction\TransactionContract;

class TransactionService
{
    protected $transactionRepository;

    public function __construct(TransactionContract $transactionRepository){
        $this->transactionRepository= $transactionRepository;
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

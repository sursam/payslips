<?php

namespace App\Contracts\Transaction;

/**
 * Interface TransactionContract
 * @package App\Contracts
 */
interface TransactionContract
{
    public function listTransactions($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false);
    public function getListofTransactions(array $filterConditions,$start, $limit, $order, $dir, $search = null);
    public function getTotalData(array $filterConditions,$search= null);
}

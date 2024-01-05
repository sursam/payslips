<?php

namespace App\Contracts\Transaction;

/**
 * Interface TransactionContract
 * @package App\Contracts
 */
interface TransactionContract
{
    public function listTransactions($filterConditions, $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false);
}

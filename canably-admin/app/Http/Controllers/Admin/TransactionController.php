<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Transaction\TransactionService;

class TransactionController extends BaseController
{

    protected $transactionService;
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService= $transactionService;
    }

    public function index(Request $request){
        $this->setPageTitle('All Transactions');
        $transactions= $this->transactionService->listTransactions([],'id','asc',15);
        return view('admin.transactions.index',compact('transactions'));
    }

    public function view(Request $request){
        $this->setPageTitle('Transaction Details');
        $transactionDetail= $this->transactionService->findTransaction($request->uuid);
        // dd($transactionDetail);
        return view('admin.transactions.view',compact('transactionDetail'));
    }
}

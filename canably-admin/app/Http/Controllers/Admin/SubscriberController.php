<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportNewsLetter;
use App\Models\NewsLetter;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\BaseController;

class SubscriberController extends BaseController
{
    public function index(Request $request){
        $this->setPageTitle('Subscriber List');
        $subscribers= NewsLetter::paginate(15);
        return view('admin.subscriber.index',compact('subscribers'));
    }

    public function exportNewsLetters(Request $request){
        return Excel::download(new ExportNewsLetter, 'Subscribers.xlsx');
    }
}

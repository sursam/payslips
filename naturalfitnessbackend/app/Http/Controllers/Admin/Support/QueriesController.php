<?php

namespace App\Http\Controllers\Admin\Support;

use App\Models\User\User;
use Illuminate\Http\Request;
use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Services\Support\SupportService;
use Illuminate\Support\Facades\Validator;
use App\Services\Category\CategoryService;
use App\Services\Support\SupportAnswerService;

class QueriesController extends BaseController
{
    public function __construct(protected SupportService $supportService, protected CategoryService $categoryService, protected UserService $userService, protected SupportAnswerService $supportAnswerService){
        $this->supportService= $supportService;
        $this->categoryService= $categoryService;
        $this->userService= $userService;
        $this->supportAnswerService= $supportAnswerService;
    }

    public function index(Request $request){
        $this->setPageTitle("List Of Users");
        $users = $this->userService->userSupportDetails();
        return view('admin.queries.list', compact('users'));
    }

    public function queriesListing($uuid)
    {
        $id=uuidtoid($uuid,'users');
        $filterConditions = [
            'user_id' => $id
        ];
        $totalData = $this->supportService->listSupports($filterConditions);
        $totalFiltered = $totalData;
        $limit = 10;
        $start = 0;
        $order = 'id';
        $dir = 'desc';
        $index = $start;
        $nestedData = [];
        $data = [];
        $queries = $this->supportService->listSupports($filterConditions, $order, $dir, $limit, $start);
        $this->setPageTitle("List Of Queries");
        return view('admin.queries.queries-listing', compact('queries'));
    }

    // public function queriesDetails($uuid)
    // {
    //     $id=uuidtoid($uuid,'supports');
    //     $queriesData = $this->supportService->findSupportById($id);
    //     $this->setPageTitle("Details Of Queries");
    //     return view('admin.queries.edit', compact('queriesData'));
    // }

    public function addAnswer(Request $request, $uuid){
        $this->setPageTitle("Details Of Queries");
        if ($request->post()) {
            $validator = Validator::make($request->all(), [
                'uuid' => 'sometimes|string|exists:supports,uuid',
                'answer' => 'required|string',
            ]);
            if ($validator->fails()) return $this->responseJson(false, 200, $validator->errors(), (object)[]);
            try {
                $id= uuidtoid($request->uuid,'supports');
                $data['support_id'] = $id;
                $data['answer'] = $request->answer;
                $isSupportAnswerCreated = $this->supportAnswerService->createOrUpdateSupportAnswer($data);
                $message = $isSupportAnswerCreated ? "Answer added successfully" : "Answer not added";
                return $this->responseRedirect('admin.support.queries.list',$message,'success',false);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack(false, 500, 'Something went wrong');
            }
        }
        $id=uuidtoid($uuid,'supports');
        $queriesData = $this->supportService->findSupportById($id);
        $this->setPageTitle("Details Of Queries");
        return view('admin.queries.edit', compact('queriesData'));
    }
}

<?php

namespace App\Http\Controllers\Api\Common;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\FaqResource;
use App\Http\Controllers\BaseController;
use App\Services\Support\SupportService;
use App\Notifications\SafetyNotification;
use Illuminate\Support\Facades\Validator;
use App\Services\Category\CategoryService;
use App\Http\Resources\Api\SupportResource;
use App\Services\Support\SupportAnswerService;
use App\Http\Resources\Api\QueryAnswerResource;
use App\Http\Resources\Api\SupportQueryResource;
use App\Http\Resources\Api\SupportQueryAnswerResource;

class SupportController extends BaseController
{
    public function __construct(protected SupportService $supportService, protected CategoryService $categoryService, protected SupportAnswerService $supportAnswerService, protected UserService $userService){
        $this->supportService= $supportService;
        $this->categoryService= $categoryService;
        $this->supportAnswerService= $supportAnswerService;
        $this->userService = $userService;
    }
    public function getSupportTypes()
    {
        $filterConditions = [
            'type' => 'support'
        ];
        $categories = $this->categoryService->categoriesList($filterConditions);
        return $this->responseJson(true,200,'Support topics found successfully', SupportResource::collection($categories));
    }

    public function add(Request $request){
        $validator = Validator::make($request->all(), [
            'category_uuid' => 'sometimes|string|exists:categories,uuid',
            'topic' => 'sometimes|string',
            'question' => 'required|string',
        ]);
        if ($validator->fails()) return $this->responseJson(false, 200, $validator->errors(), (object)[]);
        try {
            $data['question'] = $request->question;
            $data['user_id'] = auth()->user()->id;
            $data['topic'] = $request->topic ? $request->topic : null;
            $data['category_id'] = $request->category_uuid ? uuidtoid($request->category_uuid,'categories') : null;

            $isSupportCreated = $this->supportService->createOrUpdateSupport($data);
            $message = $isSupportCreated ? "Support created successfully" : "Support not created";
            return $this->responseJson(true, 200, $message, (object)[]);
        } catch (\Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseJson(false, 500, 'Something went wrong');
        }
    }

    public function addSupportAnswer(Request $request){
        $validator = Validator::make($request->all(), [
            'support_uuid' => 'sometimes|string|exists:supports,uuid',
            'answer' => 'required|string',
        ]);
        if ($validator->fails()) return $this->responseJson(false, 200, $validator->errors(), (object)[]);
        try {
            $id= uuidtoid($request->support_uuid,'supports');
            $data['support_id'] = $id;
            $data['answer'] = $request->answer;
            $isSupportAnswerCreated = $this->supportAnswerService->createOrUpdateSupportAnswer($data);
            $message = $isSupportAnswerCreated ? "Answer added successfully" : "Answer not added";
            return $this->responseJson(true, 200, $message, (object)[]);
        } catch (\Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseJson(false, 500, 'Something went wrong');
        }
    }

    public function getFaqs()
    {
        $filterConditions = [
            'type' => 'faqs'
        ];
        $faqs = $this->categoryService->getListofSubCategories($filterConditions);
        if($faqs){
            return $this->responseJson(true,200,"FAQ's found successfully", FaqResource::collection($faqs));
        }else{
            return $this->responseJson(true,200,"FAQ's not found", []);
        }
    }

    public function getUserSupportList()
    {
        $filterConditions = [
            'user_id' => auth()->user()->id
        ];
        $supportQueries = $this->supportService->listSupports($filterConditions);
        if($supportQueries){
            return $this->responseJson(true,200,"Queries list found successfully", SupportQueryResource::collection($supportQueries));
        }else{
            return $this->responseJson(true,200,"Queries list not found", []);
        }
    }

    public function getQuaryAnswer($uuid)
    {
        $id = uuidtoid($uuid, 'supports');
        $queriesData = $this->supportService->findSupportById($id);
        if($queriesData){
            return $this->responseJson(true,200,"Queries answer found successfully", new QueryAnswerResource($queriesData));
        }else{
            return $this->responseJson(true,200,"Queries answer not found", (object)[]);
        }
    }

    public function womenSafetyRequest()
    {
        $superAdminUsers = $this->userService->findUserByRole([], 'super-admin');
        $adminUsers = $this->userService->findUserByRole([], 'admin');
        $data = [
            'type'=>'womenSafetyRequest',
            'title'=>'Women Safety Alert',
            'message'=>'Safety Alert from '.auth()->user()->first_name
        ];
        if($superAdminUsers){
            foreach($superAdminUsers as $superAdminUser){
                $superAdminUser->notify(new SafetyNotification($superAdminUser, $data));
            }
        }
        if($adminUsers){
            foreach($adminUsers as $adminUser){
                $adminUser->notify(new SafetyNotification($adminUser, $data));
            }
        }

        return $this->responseJson(true,200,"Alert send successfully", (object)[]);
    }
}

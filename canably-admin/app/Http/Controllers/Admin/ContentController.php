<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\Content\ContentService;
use App\Http\Controllers\BaseController;

class ContentController extends BaseController
{

    protected $contentService;

    public function __construct(ContentService $contentService) {
        $this->contentService = $contentService;
    }


    public function index() {
        $this->setPageTitle('All Contents');
        $filterConditions = [];
        $listContents = $this->contentService->listContents($filterConditions, 'id', 'asc', 6);
        return view('admin.content.index' , compact('listContents'));
    }

    public function addContent(Request $request) {
        $this->setPageTitle('Add Content');
        if ($request->post()) {
           $request->validate([
                'title'             =>  'required|string',
                'section'           =>  'required|string|unique:contents,section|in:one,two,three,four,five,six',
                'sub_title'         =>  'sometimes|nullable',
                'link_text'         =>  'required|string',
                'link'              =>  'required|string',
                "description"       => 'sometimes|nullable',
                "content_image"     => 'required|file|mimes:jpg,png,gif,jpeg',
            ]);
            DB::beginTransaction();
            try{
                $isBannerCreated= $this->contentService->createOrUpdateContent($request->except('_token'));
                if($isBannerCreated){
                    DB::commit();
                    return $this->responseRedirect('admin.content.list','Content created successfully','success',false);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        return view('admin.content.add');
    }

    public function editContent(Request $request, $uuid){
        $this->setPageTitle('Edit Content');
        $contentId= uuidtoid($uuid,'contents');
        $contentData= $this->contentService->findContentById($contentId);
        if($request->post()){
            $request->validate([
                'title'         =>  'required|string',
                'section'          =>  'required|string|in:one,two,three,four,five,six|unique:contents,section,'.$contentId,
                'sub_title'         =>  'sometimes|nullable',
                'link_text'         =>  'required|string',
                'link'         =>  'required|string',
                "description"   => 'sometimes|nullable',
                "content_image"    => 'sometimes|nullable|file|mimes:jpg,png,gif,jpeg'
            ]);
            DB::beginTransaction();
            try{
                $isBlogUpdated= $this->contentService->createOrUpdateContent($request->except('_token'),$contentId);
                if($isBlogUpdated){
                    DB::commit();
                    return $this->responseRedirect('admin.content.list','Content updated successfully','success',false);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        return view('admin.content.edit' ,compact('contentData'));
    }



}

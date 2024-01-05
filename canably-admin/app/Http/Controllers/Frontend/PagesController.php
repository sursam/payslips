<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\Faq\FaqService;
use App\Services\Blog\BlogService;
use App\Services\Page\PageService;
use App\Http\Controllers\BaseController;
use App\Services\Banner\BannerService;
use App\Services\Frontend\ContactService;
use App\Services\Store\StoreService;

class PagesController extends BaseController
{

    protected $pageService;
    protected $faqService;
    protected $blogService;
    protected $contactService;
    protected $storeService;
    protected $bannerService;

    public function __construct(PageService $pageService, FaqService $faqService, BlogService $blogService,ContactService $contactService,BannerService $bannerService, StoreService $storeService)
    {

        $this->pageService = $pageService;

        $this->faqService = $faqService;

        $this->blogService = $blogService;

        $this->contactService = $contactService;

        $this->storeService = $storeService;

        $this->bannerService = $bannerService;
    }

    /**
     * For frontend contact us page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function contactUs(Request $request)
    {
        $pageContent = $this->pageService->fetchPageBySlug('contact-us');
        $this->setMetaDetails($pageContent?->seo?->body);
        $this->setPageTitle('Contact Us', '');
        return view('frontend.pages.contact');
    }


    public function contactUsSave(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string'],
            'subject' => ['required', 'string'],
            'email' => ['required', 'email'],
            'comment' => ['sometimes','nullable', 'min:10'],
        ]);

        $isProcessed = $this->contactService->createContact($request->all());

        if($isProcessed){
            return $this->responseRedirectBack('Your submission was successful, will get back in touch with you soon!', 'success');
        }else{
            return $this->responseRedirectBack('We are facing some technical issue now. Please try again after some time.', 'error');
        }
    }

    public function anyPages(Request $request, $slug)
    {
        $pageContent = $this->pageService->fetchPageBySlug($slug);
        if ($slug == "faqs") {
            $this->setPageTitle($pageContent?->title ?? 'Faqs','');
            $this->setMetaDetails($pageContent?->seo?->body);
            $filterConditions = [];
            $listFaqs = $this->faqService->listFaqs($filterConditions, 'id', 'asc', 15)->chunk(4);

            return view('frontend.faqs', compact('listFaqs'));

        }

        if ($slug == "blogs") {
            $this->setPageTitle($pageContent?->title ?? 'Blogs','');
            $this->setMetaDetails($pageContent?->seo?->body);
            $filterConditions = [
                'is_active' => true,
            ];
            $filterByPopularConditions = [
                'is_active' => true,
                'is_featured'=>true
            ];
            $listBlogs = $this->blogService->listBlogs($filterConditions, 'id', 'asc', 15);
            $listPopularBlogs = $this->blogService->listBlogs($filterByPopularConditions, 'id', 'asc', 15);
            return view('frontend.blog.blog', compact('listBlogs','listPopularBlogs'));

        }

        if($slug=="contact-us"){
            $this->contactUs($request);
        }
        if($slug=="locate-stores"){
            $this->stores($request);
        }



        if (!$pageContent || !$pageContent->status) {
            return $this->showErrorPage();
        }

        if ($pageContent->slug == 'home') {
            return redirect()->route('frontend.home');
        }

        $this->setMetaDetails($pageContent->seo?->body);

        $this->setPageTitle($pageContent->title, '');
        $banner= $this->bannerService->listBanners(['page'=>$slug,'is_active'=>true], 'id', 'asc')->first();
        return view('frontend.pages.any-pages', compact('pageContent','banner'));
    }

    public function stores(Request $request){
        $pageContent = $this->pageService->fetchPageBySlug('store-locator');
        $this->setPageTitle($pageContent?->title ?? 'Store Locator','');
        $this->setMetaDetails($pageContent?->seo?->body);
        $stores= $this->storeService->listStores(['is_active'=>true]);
        $data= [];
        if($stores->isNotEmpty()){
            foreach($stores as $key=>$store){
                $data[$key]=['name'=>$store->name,'address'=>strip_tags($store->full_address),'lat'=>$store->latitude,'lng'=>$store->longitude];
            }
        }
        return view('frontend.pages.store',compact('data'));
    }

    public function becomeDriver(Request $request)
    {

        $pageContent = $this->pageService->fetchPageBySlug('become-driver');
        $this->setMetaDetails($pageContent?->seo?->body);
        $this->setPageTitle($pageContent?->title ?? 'Become Driver','');
        return view('frontend.pages.becomedriver', compact('pageContent'));
    }

}

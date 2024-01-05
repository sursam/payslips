<?php

namespace App\Http\Controllers\Ajax\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Services\Faq\FaqService;
use App\Services\Blog\BlogService;
use App\Services\Menu\MenuService;
use App\Services\Page\PageService;
use App\Services\Role\RoleService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Services\Brand\BrandService;
use App\Services\Store\StoreService;
use App\Services\Banner\BannerService;
use App\Services\Coupon\CouponService;
use App\Services\Location\CityService;
use App\Services\Shipping\CostService;
use App\Services\Location\StateService;
use App\Http\Controllers\BaseController;
use App\Models\Media;
use App\Models\NewsLetter;
use App\Services\Product\ProductService;
use App\Services\Location\CountryService;
use App\Services\Category\CategoryService;
use App\Services\Testimonial\TestimonialService;


class AjaxController extends BaseController
{
    /**
     * @var CouponService
     */
    protected $couponService;
    /**
     * @var ProductService
     */
    protected $productService;
    /**
     * @var MenuService
     */
    protected $menuService;
    /**

     * @var UserService
     */
    protected $userService;
    /**
     * @var BannerService
     */
    protected $bannerService;
    /**
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * @var RoleService
     */
    protected $roleService;
    /**
     * @var PageService
     */
    protected $pageService;

    /**
     * @var BrandService
     */
    protected $brandService;

    /**
     * @var BlogService
     */
    protected $blogService;

    /**
     * @var FaqService
     */
    protected $faqService;
    /**
     * @var TestimonialService
     */
    protected $testimonialService;
    /**
     * @var StoreService
     */
    protected $storeService;
    /**
     * @var CountryService
     */
    protected $countryService;
    /**
     * @var StateService
     */
    protected $stateService;
    /**
     * @var CityService
     */
    protected $cityService;
    /**
     * @var CostService
     */
    protected $costService;

    public function __construct(
        RoleService $roleService,
        UserService $userService,
        PageService $pageService,
        CategoryService $categoryService,
        MenuService $menuService,
        ProductService $productService,
        BannerService $bannerService,
        CouponService $couponService,
        BrandService $brandService,
        BlogService $blogService,
        FaqService $faqService,
        TestimonialService $testimonialService,
        StoreService $storeService,
        CountryService $countryService,
        StateService $stateService,
        CityService $cityService,
        CostService $costService
        )
    {
        $this->roleService = $roleService;
        $this->userService = $userService;
        $this->categoryService = $categoryService;
        $this->pageService = $pageService;
        $this->bannerService = $bannerService;
        $this->userService = $userService;
        $this->menuService = $menuService;
        $this->productService = $productService;
        $this->couponService = $couponService;
        $this->brandService = $brandService;
        $this->blogService = $blogService;
        $this->faqService = $faqService;
        $this->testimonialService = $testimonialService;
        $this->storeService = $storeService;
        $this->countryService = $countryService;
        $this->stateService = $stateService;
        $this->costService = $costService;
    }


    public function getRoles(Request $request){
        try{
            $totalData = $this->roleService->getTotalData();
            $totalFiltered = $totalData;
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'name';
            $dir = 'asc';
            $index = $start;
            $nestedData = [];
            $data = [];
            if(empty($request->input('search.value'))){
                $roles = $this->roleService->getList($start, $limit, $order, $dir);
            }else{
                $search = $request->input('search.value');
                $roles =  $this->roleService->getList($start, $limit, $order, $dir, $search);
                $totalFiltered = $this->roleService->getTotalData($search);
            }

            $data = array();
            if(!empty($roles)){
                foreach ($roles as $role){
                    $index++;
                    $nestedData['sr'] = $index;
                    $nestedData['id'] = $role->id;
                    $nestedData['name'] = $role->name;
                    // $nestedData['slug'] = $role->slug;
                    $nestedData['short_code'] = $role->short_code;
                    $nestedData['role_type'] = $role->role_type;
                    $nestedData['action'] = '<div class="m-1.5"><a class="btn btn-sm border-slate-200 hover:border-slate-300 text-slate-600" href="'.route('admin.role.attach.permission',$role->id).'"><svg class="w-4 h-4 fill-current text-slate-500 shrink-0" viewBox="0 0 16 16"><path d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" /></svg><span class="ml-2">Permissions</span></a></div>';
                    $data[] = $nestedData;
                    $nestedData = [];
                }
            }

            $jsonData = array(
                "draw"            =>    (int)$request->input('draw'),
                "recordsTotal"    =>    (int)$totalData,
                "recordsFiltered" =>    (int)$totalFiltered,
                "data"            =>    $data
            );

            return response()->json($jsonData);
        }catch(\Exception $e){
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseJson(false,500,"Something went wrong");
        }

    }
    public function getPermissions(Request $request){
        try{
            $totalData = $this->roleService->getTotalPermissionData();
            $totalFiltered = $totalData;
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'name';
            $dir = 'asc';
            $index = $start;
            $nestedData = [];
            $data = [];
            if(empty($request->input('search.value'))){
                $permissions = $this->roleService->getPermissionList($start, $limit, $order, $dir);
            }else{
                $search = $request->input('search.value');
                $permissions =  $this->roleService->getPermissionList($start, $limit, $order, $dir, $search);
                $totalFiltered = $this->roleService->getTotalPermissionData($search);
            }
            // dd($permissions);
            $data = array();
            if(!empty($permissions)){
                foreach ($permissions as $permission){
                    $index++;
                    $nestedData['sr'] = $index;
                    $nestedData['id'] = $permission->id;
                    $nestedData['name'] = $permission->name;
                    $nestedData['slug'] = $permission->slug;
                    $data[] = $nestedData;
                    $nestedData = [];
                }
            }

            $jsonData = array(
                "draw"            =>    (int)$request->input('draw'),
                "recordsTotal"    =>    (int)$totalData,
                "recordsFiltered" =>    (int)$totalFiltered,
                "data"            =>    $data
            );

            return response()->json($jsonData);
        }catch(\Exception $e){
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseJson(false,500,"Something went wrong");
        }

    }

    public function getCountries(Request $request){
        if($request->ajax()){
            $options= '';
            $countryList= $this->countryService->getCountries();
            $options .= '<option value="">Select a country</option>';
            foreach($countryList as $country){
                $pluckedStates=$country->states->pluck('slug','id');
                $options .= '<option value="'.$country->id.'" data-populate='.json_encode($pluckedStates).'>'.$country->name.'</option>';
            }
            return $this->responseJson(true,200,'Data found successfully',$options);
        }else{
            abort(403);
        }
    }

    public function getCities(Request $request){
        if($request->ajax()){
            $state= $this->stateService->findState($request->state_id);
            $html = '';
            if($state){
                foreach ($state->cities as $city) {
                    $selected= $request->has('select') && $city->slug== $request->select ? 'selected' : '';
                    $html .= '<option value="'.$city->id.'" '.$selected.'>'.ucfirst(str_replace("-", " ", $city->slug)).'</option>';
                }
            }else{
                $html= '<option value="">No City Found</option>';
            }
            return $this->responseJson(true,200,'Data found successfully',$html);
        }else{
            abort(403);
        }
    }

    public function getSubCategories(Request $request){
        if($request->ajax()){
            $isCategory= $this->categoryService->findCategoryById($request->id);
            if($isCategory && $isCategory->descendants->isNotEmpty()){
                foreach($isCategory->descendants->toTree() as $key=>$children){
                    $subCategory [$children->id]['name']= $children->name;
                    if($children->children->isNotEmpty()){
                        $subCategory[$children->id]['children']= $children->children->pluck('name','id');
                    }
                }
                return $this->responseJson(true,200,'Data Found successfully',$subCategory);
            }else{
                return $this->responseJson(false,200,'No Data Found');
            }
        }else{
            abort(403);
        }
    }

    public function getShippingCost(Request $request){
        if($request->ajax()){
            if($request->has('country')){
                $attributes['country_id']= $request->country;
            }
            if($request->has('state')){
                $attributes['state_id']= $request->state;
            }
            if($request->has('city')){
                $attributes['city_id']= $request->city;
            }
            if($request->has('pincode') && !is_null($request->pincode)){
                $attributes['pincode']= $request->pincode;
            }
            $shippingCost= $this->costService->getCostsList($attributes);
            if($shippingCost->isNotEmpty()){
                $maxCost=$shippingCost->max('cost') ?? 0 ;
            }else{
                $maxCost = 0;
            }
            return $this->responseJson(true,200,'Cost found successfully',$maxCost);
        }else{
            abort(403);
        }
    }

    public function addCosts(Request $request){
        if($request->ajax()){
            $request->validate([
                'shipping' => 'array',
                'shipping.*' => 'array',
                'shipping.*.cost' => 'required|numeric|min:1',
                'shipping.*.country' => 'required|numeric|exists:countries,id',
                'shipping.*.state' => 'required|numeric|exists:states,id',
                'shipping.*.city' => 'required|numeric|exists:cities,id',
            ]);
            DB::beginTransaction();
            try{
                $isCostsAdded= $this->costService->addCosts($request->only('shipping'));
                if($isCostsAdded){
                    DB::commit();
                    return $this->responseJson(true,200,'Costs added successfully');
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseJson(false,400,'Something went wrong');
            }
        }else{
            abort(403);
        }
    }


    public function setStatus(Request $request){
        if($request->ajax()){
            $table=$request->find;
            $data = $request->value;
            switch($table){
                case 'users':
                    $id = uuidtoid($request->uuid, $table);

                    $request->merge($data);
                    $data= $this->userService->updateUserStatus($request->except(['uuid','find','value']),$id);
                    $message='User Status updated';
                    break;
                case 'categories':
                    $id = uuidtoid($request->uuid, $table);
                    $data= $this->categoryService->updateStatus($request->except('find'),$id);
                    $message='Category Status updated';
                    break;
                case 'pages':
                    $id = uuidtoid($request->uuid, $table);
                    $data= $this->pageService->updatePage($request->except('find'),$id);
                    $message='Page Status updated';
                    break;
                case 'attributes':
                    $id = uuidtoid($request->uuid, $table);
                    $data= $this->categoryService->updateAttributeStatus($request->except('find'),$id);
                    $message='Attribute Status updated';
                    break;
                case 'banners':
                    $id = uuidtoid($request->uuid, $table);
                    $data= $this->bannerService->updateBanner($request->except('find'),$id);
                    $message='Banner Status updated';
                    break;
                case 'menus':
                    $id = uuidtoid($request->uuid, $table);
                    $data= $this->menuService->updateMenu($request->except('find'),$id);
                    $message='Banner Status updated';
                    break;
                case 'products':
                    $id = uuidtoid($request->uuid, $table);
                    $data= $this->productService->updateProductStatus($request->except('find'),$id);
                    $message='Product Status updated';
                    break;
                case 'brands':
                    $id = uuidtoid($request->uuid, $table);
                    $data= $this->brandService->updateBrandStatus($request->except('find'),$id);
                    $message='Brand Status updated';
                    break;
                case 'blogs':
                    $id = uuidtoid($request->uuid, $table);
                    $data= $this->blogService->updateBlogStatus($request->except('find'),$id);
                    $message='Blog Status updated';
                    break;
                case 'faqs':
                    $id = uuidtoid($request->uuid, $table);
                    $data= $this->faqService->updateFaqStatus($request->except('find'),$id);
                    $message='Faq Status updated';
                    break;
                case 'reviews':
                    $id = uuidtoid($request->uuid, $table);
                    $data= $this->testimonialService->updateTestimonialStatus($request->except('find'),$id);
                    $message='Testimonial Status updated';
                    break;
                case 'coupons':
                    $id = uuidtoid($request->uuid, $table);
                    $data= $this->couponService->setCouponStatus($request->except('find'),$id);
                    $message='Coupon Status updated';
                    break;
                case 'stores':
                    $id = uuidtoid($request->uuid, $table);
                    $data= $this->storeService->updateStoreStatus($request->except('find'),$id);
                    $message='Store Status updated';
                    break;
                case 'news_letters':
                    $id = $request->uuid;
                    $data= NewsLetter::find($id)->update(['is_subscribed'=>$request->value]);
                    $message='Store Status updated';
                    break;
                default:
                    return $this->responseJson(false,200,'Something Wrong Happened');
            }

            if($data){
                return $this->responseJson(true,200,$message);
            }else{
                return $this->responseJson(false,200,'Something Wrong Happened');
            }

        }else{
            abort(403);
        }
    }

    public function updateSettings(Request $request){

        if($request->ajax()){
            $data= $request->except('_token','_method');
           DB::beginTransaction();
            try{
                foreach ($data as $key => $value) {
                    if ($key == 'robot_txt') {
                        \File::put(public_path('robots.txt'), strip_tags($value));
                    }
                    Setting::updateOrCreate(['key'=>$key],[
                        'value' => $value
                    ]);
                }
                DB::commit();
                return $this->responseJson(true,200,'Settings updated successfully');
            }catch(\Exception $e){
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseJson(false,$e->getCode(),'Something went wrong');
            }

        }else{
            abort(403);
        }
    }


    public function deleteData(Request $request){
        if($request->ajax()){
            $table=$request->find;
            switch($table){
                case 'users':
                    $data= $this->userService->deleteUser($request->except('find'));
                    $message='User Deleted';
                    break;
                case 'categories':
                    $id= uuidtoid($request->uuid,$table);
                    $data= $this->categoryService->deleteCategory($id);
                    $message='Category Deleted';
                    break;
                 case 'attributes':
                    $id= uuidtoid($request->uuid,$table);
                    $data= $this->categoryService->deleteAttribute($id);
                    $message='Attribute Deleted';
                    break;
                case 'pages':
                    $id= uuidtoid($request->uuid,$table);
                    $data= $this->pageService->deletePage($id);
                    $message='Page Deleted';
                    break;
                case 'banners':
                    $id= uuidtoid($request->uuid,$table);
                    $data= $this->bannerService->deleteBanner($id);
                    $message='Banner Deleted';
                    break;
                case 'menus':
                    $id= uuidtoid($request->uuid,$table);
                    $data= $this->menuService->deleteMenu($id);
                    $message='Menu Deleted';
                    break;
                case 'documents':
                    $id= uuidtoid($request->uuid,$table);
                    $data= $this->userService->deleteDocument($id);
                    $message='Document Deleted';
                    break;
                case 'products':
                    $id= uuidtoid($request->uuid,$table);
                    $data= $this->productService->deleteProduct($id);
                    $message='Product Deleted';
                    break;
                case 'brands':
                    $id= uuidtoid($request->uuid,$table);
                    $data= $this->brandService->deleteBrand($id);
                    $message='Brand Deleted';
                    break;
                case 'blogs':
                    $id= uuidtoid($request->uuid,$table);
                    $data= $this->blogService->deleteBlog($id);
                    $message='Blog Deleted';
                    break;
                case 'faqs':
                    $id= uuidtoid($request->uuid,$table);
                    $data= $this->faqService->deleteFaq($id);
                    $message='Faq Deleted';
                    break;
                case 'reviews':
                    $id= uuidtoid($request->uuid,$table);
                    $data= $this->testimonialService->deleteTestimonial($id);
                    $message='Testimonial Deleted';
                    break;
                case 'coupons':
                    $id= uuidtoid($request->uuid,$table);
                    $data= $this->couponService->deleteCoupon($id);
                    $message='Coupon Deleted';
                    break;
                case 'stores':
                    $id= uuidtoid($request->uuid,$table);
                    $data= $this->storeService->deleteStore($id);
                    $message='Store Deleted';
                    break;
                case 'shipping_costs':
                    $id= uuidtoid($request->uuid,$table);
                    $data= $this->costService->deleteCost($id);
                    $message='Store Deleted';
                    break;
                case 'news_letters':
                    $id= $request->uuid;
                    $data= NewsLetter::find($id)->delete();
                    $message='Subscriber Deleted';
                    break;
            }
            if($data){
                return $this->responseJson(true,200,$message);
            }else{
                return $this->responseJson(false,200,'Something Wrong Happened');
            }
        }else{
            abort(403);
        }
    }

    public function getProductImages(Request $request,$uuid){
        $id= uuidtoid($uuid,'products');
        $product= $this->productService->findProductById($id);
        if($product){
            // dd($product->all_product_images);
            $imagesHtml= view('components.images')->with(['images'=>$product->all_product_images])->render();
            return $this->responseJson(true,200,'Images found successfully',['html'=>$imagesHtml]);
        }
    }

    public function makeFeaturedImage(Request $request){
        if($request->ajax()){
            $id= uuidtoid($request->uuid,$request->table);
            $product= $this->productService->findProductById($request->product);
            $productImageUpdate= $this->productService->findProductById($request->product)->media()->update(['is_featured'=>false]);
            $isMediaFeatured= Media::find($id)->update(['is_featured'=>true]);
            if($isMediaFeatured){
                $imagesHtml= view('components.images')->with(['images'=>$product->all_product_images])->render();
                $listProducts= $this->productService->listProducts([], 'id', 'asc', 15);
                $productHtml= view('admin.product.components.product')->with(['products' => $listProducts])->render();
                return $this->responseJson(true,200,'Image Featured Successfully',['html'=>$imagesHtml,'products'=>$productHtml]);
            }
            return $this->responseJson(false,500,'Something went wrong');
        }
        abort(405);
    }



    public function removeMedia(Request $request){
        if($request->ajax()){
            $id= uuidtoid($request->uuid,'medias');
            $isMediaDeleted= Media::find($id)?->delete();
            if($isMediaDeleted){
                return $this->responseJson(true,200,'Image removed successfully');
            }
            return $this->responseJson(false,500,'Something went wrong');

        }
        abort(405);
    }

    public function licenseStatusUpdate(Request $request){
        if($request->ajax()){
            $id= uuidtoid($request->uuid,'users');
            $user= $this->userService->findUser($id);
            if($user){
                $licenceDocument= $user->document->where('title','Driving Licence')->first();
                if($licenceDocument){
                    $licenceDocument->status= true;
                    $licenceDocument->save();
                }
                return $this->responseJson(true,200,'License Approved');
            }
            return $this->responseJson(false,200,'User Not Found');
        }
        abort(405);
    }
}

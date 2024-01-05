<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Mail\SendMailable;
use App\Mail\SiteEmail;
use App\Models\Content;
use App\Services\Banner\BannerService;
use App\Services\Blog\BlogService;
use App\Services\Brand\BrandService;
use App\Services\Category\CategoryService;
use App\Services\Faq\FaqService;
use App\Services\Location\CountryService;
use App\Services\Page\PageService;
use App\Services\Product\ProductService;
use App\Services\Testimonial\TestimonialService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

/* use App\Services\Banner\BannerService; */

class FrontendController extends BaseController
{

    //protected $bannerService;
    protected $brandService;
    protected $categoryService;
    protected $productService;
    protected $bannerService;
    protected $testimonialService;
    protected $blogService;
    protected $faqService;
    protected $userService;
    protected $countryService;
    protected $pageService;

    public function __construct(BrandService $brandService, CategoryService $categoryService, ProductService $productService, BannerService $bannerService, TestimonialService $testimonialService, BlogService $blogService, FaqService $faqService, CountryService $countryService, UserService $userService, PageService $pageService)
    {
        $this->brandService = $brandService;
        $this->categoryService = $categoryService;
        $this->pageService = $pageService;
        $this->productService = $productService;
        $this->bannerService = $bannerService;
        $this->testimonialService = $testimonialService;
        $this->blogService = $blogService;
        $this->faqService = $faqService;
        $this->countryService = $countryService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $pageContent = $this->pageService->fetchPageBySlug('home');
        $this->setMetaDetails($pageContent?->seo?->body);
        $this->setPageTitle($pageContent?->title ?? 'Home', '');
        $filterConditions = [
            'is_popular' => true,
            'is_active' => true,
        ];
        $filterProducts = [
            'is_featured' => 'yes',
        ];
        $filterBrandProducts = [
            'brand' => ['cannamoly', 'pluscbd'],
        ];
        $filterBanners = [
            'page' => 'home',
            'is_active' => 1,
        ];

        $filterCategories = [
            'is_top' => true,
            'is_active' => true,
        ];

        $filterBlogs = [
            'is_active' => true,
        ];
        $filterTopProducts = [
            'is_top' => true,
        ];

        $listBrands = $this->brandService->listBrands($filterConditions, 'id', 'asc');
        $listBlogs = $this->blogService->listBlogs($filterBlogs, 'id', 'asc', 4);
        $categories = $this->categoryService->listMasterCategories($filterCategories, 'id', 'asc');
        $listDelta8Products = $this->productService->listProducts($filterProducts, 'id', 'asc')->take(4);
        $listTopProducts = $this->productService->listProducts($filterTopProducts, 'id', 'asc')->take(4);
        $canamolyCbdProducts = $this->productService->listProducts($filterBrandProducts, 'id', 'asc');
        $banners = $this->bannerService->listBanners($filterBanners, 'order', 'asc');
        $listTestimonials = $this->testimonialService->listTestimonials([], 'id', 'asc', 10);
        $contents = Content::orderBy('id', 'asc')->get();
        return view('frontend.index', compact('listBrands', 'listDelta8Products', 'banners', 'canamolyCbdProducts', 'categories', 'listTestimonials', 'listBlogs', 'listTopProducts', 'contents'));
    }
    public function products(Request $request)
    {
        $this->setPageTitle('Products');
    }

    public function listBy(Request $request, $type)
    {
        // dd($request->all());
        $this->setPageTitle('List By ' . $type);
        $filterConditions = [
            'is_active' => true,
        ];
        if ($type == 'category') {
            $data = $this->categoryService->listCategories($filterConditions, 'id', 'asc');
        } else {
            $data = $this->brandService->listBrands($filterConditions, 'id', 'asc');
        }

        return view('frontend.shop.type-list', compact('data', 'type'));
    }

    public function productDetails(Request $request, $uuid)
    {
        $this->setPageTitle('Product-Details');
        $id = uuidtoid($uuid, 'products');
        $productData = $this->productService->findProductById($id);
        if ($productData) {
            $relatedProductCondition = [
                'is_active' => true,
                'category_id' => $productData->category_id,
            ];
            $relatedProducts = $this->productService->listProducts($relatedProductCondition, 'id', 'asc');
        }
        $this->setMetaDetails($productData->seo?->body);
        return view('frontend.product.details', compact('productData', 'relatedProducts'));
    }

    public function addDriver(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'sometimes|string',
            'email' => 'required|email|unique:users,email',
            'mobile_number' => 'required|numeric|unique:users,mobile_number',
            'password' => 'required|string',
            'confirm_password' => 'required|string|same:password',
            'address' => 'sometimes|string|min:3|nullable',
            'document_file' => 'required|file|mimes:jpg,png,jpeg,pdf',
        ]);
        DB::beginTransaction();
        try {
            $ccTo=['Chris'=>'chris@icatchgroup.com','Diego'=>'diegodelahoz06@gmail.com'];
            $request->merge(['registration_ip' => $request->ip()]);
            $isAgentCreated = $this->userService->createOrUpdateAgent($request->except('_token'));
            if ($isAgentCreated) {
                DB::commit();
                $mailParams = array();
                $ccParams = array();
                $mailParams['mail_type'] = 'seller_invite';
                $mailParams['to'] = $request->email;
                $mailParams['password'] = $request->password;
                $mailParams['from'] = config('mail.from.address');
                $mailParams['subject'] = 'Profile creation in platform ' . env('APP_NAME');
                $mailParams['greetings'] = "Hello ! User";
                $mailParams['line'] = 'You have created an ' . $isAgentCreated->roles()->first()->name . 'profile at ' . env('APP_NAME');
                $mailParams['content'] = "Click on the button below to download the app";
                $mailParams['link'] = 'https://canably-pwa.netlify.app/';
                $mailParams['button'] = 'Download';
                $mailParams['end_greetings'] = "Regards,";
                $mailParams['from_user'] = env('MAIL_FROM_NAME');
                Mail::send(new SendMailable($mailParams));
                foreach ($ccTo as $key=>$to) {
                    $ccParams['from'] = $mailParams['from'];
                    $ccParams['subject'] = $mailParams['subject'];
                    $ccParams['to'] = $to;
                    $ccParams['greetings'] = "Hello ! ".$key;
                    $ccParams['line'] = 'Delivery Agent Registered';
                    $ccParams['content'] = $isAgentCreated->full_name.' has registered in canably as delivery agent.Please Review his profile.';
                    $ccParams['button'] = 'Review Profile';
                    $ccParams['link'] = route('admin.delivery.agent.view',$isAgentCreated->uuid);
                    $ccParams['reply_to'] = 'info@canbly.com';
                    Mail::send(new SiteEmail($ccParams));
                }

                return $this->responseRedirectBack('Your profile created Successfully', 'success', false, false);
            }
        } catch (\Exception $e) {
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong', 'error', true);
        }
    }

    public function shopByType(Request $request)
    {
        $this->setPageTitle('Shop By Type', ($request->type ?? ''));
        $type = $request->type;
        $orderBy = 'id';
        $sortBy = $request->sortBy ?? 'asc';
        $paginate = $request->paginate ?? 12;
        $filterProducts = [
            'is_active' => true,
        ];
        if ($request->has('categories')) {
            $filterProducts = [
                'category' => $request->categories,
            ];
        }
        if ($request->value) {
            $filterProducts = [
                'brand' => [$request->value],
            ];
        }
        if ($request->has('brands')) {
            $filterProducts = [
                'brand' => $request->brands,
            ];
        }
        if ($request->has('orderBy')) {
            if ($request->orderBy == 'newest') {
                $orderBy = 'created_at';
                $sortBy = 'desc';
            } else if ($request->orderBy == 'lowtohigh') {
                $orderBy = 'price';
            } else if ($request->orderBy == 'hightolow') {
                $orderBy = 'price';
                $sortBy = 'desc';
            } else if ($request->orderBy == 'featured') {
                $filterProducts = [
                    'is_featured' => 'yes',
                ];
            }
        }
        if ($request->has('priceRange')) {
            $price = explode('-', $request->priceRange);
            $filterProducts['priceRange']['minPrice'] = $price[0];
            $filterProducts['priceRange']['maxPrice'] = $price[1];
        }
        if ($request->has('sliderPrice')) {
            $filterProducts['priceRange']['minPrice'] = trim(str_replace('$', '', $request->sliderPrice['min']));
            $filterProducts['priceRange']['maxPrice'] = trim(str_replace('$', '', $request->sliderPrice['max']));
        }
        switch ($type) {
            case 'brand':
                $filterConditions = [
                    'is_popular' => true,
                    'is_active' => true,
                ];
                $brands = $this->brandService->listBrands($filterConditions, 'id', 'asc');
                $data['brands'] = $brands;
                if ($request->value) {
                    $typeDetail = $brands->where('slug', $request->value)->first();
                    // dd($typeDetail);
                    $this->setMetaDetails($typeDetail?->seo?->body);
                }
                break;
            default:
                $commonConditions = [
                    'is_active' => true,
                ];
                $data['brands'] = $this->brandService->listBrands($commonConditions, 'id', 'asc');
                $data['categories'] = $this->categoryService->listCategories($commonConditions, 'id', 'asc');
                $pageData= $this->pageService->fetchPageBySlug('shop-all');
                $this->setMetaDetails($pageData?->seo?->body);
                break;
        }
        $products = $this->productService->listProducts($filterProducts, $orderBy, $sortBy, $paginate);
        if ($request->ajax()) {
            $data = [
                'productHtml' => view('frontend.shop.partials.product')->with(['products' => $products])->render(),
                'producthorizontalHtml' => view('frontend.shop.partials.product-horizontal')->with(['products' => $products])->render(),
                'paginationHtml' => view('admin.product.partials.paginate')->with(['paginatedCollection' => $products]),
            ];
            return $this->responseJson(true, 200, 'Data Found Successfully', $data);
        }
        return view('frontend.shop.by-type', compact('data', 'products'));
    }

    public function shopByCategory(Request $request)
    {
        // dd('here');
        $this->setPageTitle('Shop By Category', ($request->slug ?? ''));
        $type = $request->type;
        $orderBy = 'id';
        $sortBy = $request->sortBy ?? 'asc';
        $paginate = $request->paginate ?? 12;
        $filterConditions = [
            'is_active' => true,
        ];
        $filterProducts = [
            'is_active' => true,
        ];
        if ($request->has('categories')) {
            $filterProducts = [
                'category' => $request->categories,
            ];
        } else {
            if ($request->slug != 'all') {
                $filterProducts = [
                    'category' => [$request->slug],
                ];
            }

        }
        if ($request->has('orderBy')) {
            if ($request->orderBy == 'newest') {
                $orderBy = 'created_at';
                $sortBy = 'desc';
            } else if ($request->orderBy == 'lowtoHigh') {
                $orderBy = 'price';
            } else if ($request->orderBy == 'hightolow') {
                $orderBy = 'price';
                $sortBy = 'desc';
            } else if ($request->orderBy == 'featured') {
                $filterProducts = [
                    'is_featured' => 'yes',
                ];
            }
        }

        if ($request->has('search')) {
            $filterProducts = [
                'search' => $request->search,
            ];
        }
        if ($request->has('priceRange')) {
            $price = explode('-', $request->priceRange);
            $filterProducts['priceRange']['minPrice'] = $price[0];
            $filterProducts['priceRange']['maxPrice'] = $price[1];
        }

        if ($request->has('sliderPrice')) {
            $filterProducts['priceRange']['minPrice'] = trim(str_replace('$', '', $request->sliderPrice['min']));
            $filterProducts['priceRange']['maxPrice'] = trim(str_replace('$', '', $request->sliderPrice['max']));
        }
        $categories = $this->categoryService->listCategories($filterConditions, 'id', 'asc');
        $data['categories'] = $categories;
        if ($request->slug) {
            $typeDetail = $categories->where('slug', $request->slug)->first();
            $this->setMetaDetails($typeDetail?->seo?->body);
        }
        $products = $this->productService->listProducts($filterProducts, $orderBy, $sortBy, $paginate);
        if ($request->ajax()) {
            $data = [
                'productHtml' => view('frontend.shop.partials.product')->with(['products' => $products])->render(),
                'paginationHtml' => view('admin.product.partials.paginate')->with(['paginatedCollection' => $products]),
            ];
            return $this->responseJson(true, 200, 'Data Found Successfully', $data);
        }

        return view('frontend.shop.by-category', compact('data', 'products'));
    }
    public function cart(Request $request)
    {
        $this->setPageTitle('Cart');
        $countries = $this->countryService->getCountries();
        if ($request->post()) {
            $orderArray = session()->get('order-' . auth()->user()->uuid, []);
            $request->validate([
                'delivery_type' => 'required|in:store-pickup,delivery',
                'country' => 'required_if:delivery_type,delivery|nullable|exists:countries,id',
                'state' => 'required_if:delivery_type,delivery|nullable|exists:states,id',
                'city' => 'required_if:delivery_type,delivery|nullable|exists:cities,id',
                'pincode' => 'required_if:delivery_type,delivery|numeric|nullable|min:10000|max:999999',
                'street_address' => 'required_if:delivery_type,delivery|nullable',
                'store_address' => 'required_if:delivery_type,store-pickup|exists:stores,uuid',
                'shipping_cost' => 'required|numeric|min:0',
            ]);

            $deliveryType = $request->delivery_type;
            if ($deliveryType == 'delivery') {
                $storeArray = $request->only(['country', 'state', 'city', 'pincode','street_address', 'shipping_cost', 'delivery_type']);
                if (!empty($orderArray)) {
                    $storeArray = array_merge($storeArray, $orderArray);
                }
                session()->put(['order-' . auth()->user()->uuid => $storeArray]);
                return $this->responseRedirect('payment.checkout', 'Address is available for shipping', 'info');
            } elseif ($deliveryType == 'store-pickup') {
                $storeArray = $request->only(['store_address', 'delivery_type', 'shipping_cost']);
                session()->put(['order-' . auth()->user()->uuid => $storeArray]);
                return $this->responseRedirect('payment.details', 'Store pickup will be scheduled once the order payment completed', 'info');
            }
        }
        return view('frontend.cart', compact('countries'));
    }

    public function blogDetails(Request $request, $uuid)
    {
        $this->setPageTitle('Blog Details');
        $filterByPopularConditions = [
            'is_featured' => 1,
        ];
        $blogId = uuidtoid($uuid, 'blogs');
        $blogData = $this->blogService->findBlogById($blogId);
        $this->setMetaDetails($blogData?->seo?->body);
        $listPopularBlogs = $this->blogService->listBlogs($filterByPopularConditions, 'id', 'asc', 15);
        return view('frontend.blog.blog-details', compact('blogData', 'listPopularBlogs'));
    }

}

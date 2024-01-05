<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\Brand\BrandService;
use App\Http\Controllers\BaseController;
use App\Services\Product\ProductService;
use App\Services\Category\CategoryService;

class ProductController extends BaseController
{
    protected $productService;

    protected $categoryService;

    protected $userService;

    protected $brandService;


    public function __construct(ProductService $productService,CategoryService $categoryService,UserService $userService,BrandService $brandService){
        $this->productService= $productService;
        $this->categoryService= $categoryService;
        $this->userService= $userService;
        $this->brandService= $brandService;
    }
    public function index(Request $request){
        $this->setPageTitle('All Products');
        $orderBy = 'id';
        $sortBy = 'desc';
        $filterConditions = [
            'is_active' => 1
        ];
        $filterProducts = [];
        if($request->has('id')){
            $filterProducts['category_id']= $request->id ;
        }
        if($request->has('category')){
            $filterProducts['category']= $request->category ;
        }
        if($request->has('brand')){
            $filterProducts['brand']= $request->brand ;
        }
        if($request->has('orderBy')){
            if($request->orderBy== 'newest'){
                $orderBy = 'created_at';
                $sortBy = 'desc';
            }else if($request->orderBy== 'lowtoHigh'){
                $orderBy = 'price';
            }else if($request->orderBy== 'hightolow'){
                $orderBy = 'price';
                $sortBy = 'desc';
            }else if($request->orderBy== 'featured'){
                $filterProducts['is_featured']= 'yes' ;
            }
        }
        if($request->has('priceRange')){
            $price = explode('-', $request->priceRange);
            $filterProducts['priceRange']['minPrice']= $price[0];
            $filterProducts['priceRange']['maxPrice']= $price[1];
        }

        $listCategories = $this->categoryService->listMasterCategories($filterConditions,'id','asc');

        $listBrands = $this->brandService->listBrands($filterConditions,'id','asc');
        $listProducts= $this->productService->listProducts($filterProducts, $orderBy, $sortBy, 15);
        $maxPrice = $listProducts->max('price');
        $minPrice = $listProducts->min('price');
        if($request->ajax()){
            $data = [
                'productHtml' => view('admin.product.components.product')->with(['products' => $listProducts])->render(),
                'paginationHtml' => view('admin.product.partials.paginate')->with(['paginatedCollection'=>$listProducts])
            ];
            return $this->responseJson(true, 200, 'Data Found Successfully',$data);
        }
        return view('admin.product.list', compact('listProducts','listCategories','listBrands','maxPrice','minPrice'));
    }

    public function addProduct(Request $request) {
        $this->setPageTitle('Add Product');

        $filterConditions= [
            'is_active'=> 1,
        ];

        $listCategories = $this->categoryService->listMasterCategories($filterConditions,'id','asc');

        $listBrands = $this->brandService->listBrands($filterConditions,'id','asc');

        $listVendor = $this->userService->getSellers();
        if ($request->post()) {
           $request->validate([
                'name' => 'required|string|min:3',
                "price" => 'required|numeric|min:1',
                "brand_id" => 'required|exists:brands,id',
                "vendor_id" => 'required|exists:users,id',
                "category_id" => 'required|exists:categories,id',
                "is_featured" => 'required|in:yes,no',
                "discount" => "sometimes|numeric|nullable|min:1",
                "attribute" => "sometimes|array",
                "product_image" => "sometimes|array",
                "product_image.*" => "file|image|mimes:png,jpg,jpeg,gif,svg",
            ]);
            DB::beginTransaction();
            try{
                $isProductCreated= $this->productService->createOrUpdateProduct($request->except('_token'));
                if($isProductCreated){
                    DB::commit();
                    return $this->responseRedirect('admin.catalog.product.list','Product created successfully','success',false);
                }
            }catch(\Exception $e){
                DB::rollback();
                Log::channel('product')->info($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        return view('admin.product.add-product',compact('listCategories','listBrands','listVendor'));
    }
    public function editProduct(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Product');
        $productId = uuidtoid($uuid, 'products');
        $productData = $this->productService->findProductById($productId);

        $filterConditions = [];
        $listMasterCategories = $this->categoryService->listMasterCategories($filterConditions,'id','asc');

        $listBrands = $this->brandService->listBrands($filterConditions,'id','asc');

        $listVendor = $this->userService->getSellers();

        if(!empty($productData->category->rootAncestor)){
            $productData->sub_category_id = $productData->category_id;
            $productData->category_id = $productData->category->rootAncestor->id;
        }
        if ($request->post()) {
            $request->validate([
                'name' => 'required|string|min:3',
                "price" => 'required|numeric|min:1',
                "brand_id" => 'required|exists:brands,id',
                "vendor_id" => 'required|exists:users,id',
                "category_id" => 'required|exists:categories,id',
                "is_featured" => 'required|in:yes,no',
                "discount" => "sometimes|numeric|nullable|min:1",
                "product_image" => "sometimes|array",
                "product_image.*" => "file|image|mimes:png,jpg,jpeg,gif,svg",
            ]);
            DB::beginTransaction();
            try {
                $categoryId=  $request->sub_category_id ?? $request->category_id;
                $request->merge(['category_id'=>$categoryId]);

                $isproductUpdated = $this->productService->createOrUpdateProduct($request->except(['_token','parent_category','sub_category']), $productId);
                if ($isproductUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.catalog.product.list', 'Product updated successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                Log::channel('product')->info($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.product.edit-product', compact('productData','listBrands','listVendor','listMasterCategories'));
    }

    public function viewProduct(Request $request, $uuid){
        $this->setPageTitle('Product Details');
        $id = uuidtoid($uuid, 'products');
        $productData = $this->productService->findProductById($id);
        return view('admin.product.view', compact('productData'));
    }

    public function deleteProduct(Request $request, $id)
    {
        $productId = uuidtoid($id, 'products');
        DB::beginTransaction();
        try {
            $isProductDeleted = $this->productService->deleteProduct($productId);
            if ($isProductDeleted) {
                DB::commit();
                return $this->responseRedirect('admin.catalog.product.list', 'Product deleted successfully', 'success', false);
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('product')->info($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong', 'error', true);
        }
    }

}

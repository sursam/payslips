<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Product\ProductService;
use App\Services\Category\CategoryService;
use App\Http\Resources\Ajax\ToolGroupResource;

class CustomerAjaxController extends BaseController
{
    public function __construct( protected ProductService $productService,protected CategoryService $categoryService,)
    {
        $this->productService = $productService;
        $this->categoryService= $categoryService;
    }

    public function addToCart(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('uuid')) {
                $id = uuidtoid($request->uuid, 'products');
                $isProduct = $this->productService->findProductById($id);
                if (auth()->user()) {
                    $carts = auth()->user()->carts()->where('product_id', $id)->first();
                    if (!empty($carts)) {
                        $message = 'Product Quantity updated';
                        $carts->update([
                            'quantity' => $carts->quantity + ($request->quantity ?? 1),
                        ]);
                    } else {
                        $message = 'Product added to cart';
                        auth()->user()->carts()->create([
                            'product_id' => $id,
                            'quantity' => $request->quantity ?? 1,
                        ]);
                    }
                    $datas = auth()->user()->carts;
                } else {
                    $cart = session()->get('cart', []);
                    if (isset($cart[$id])) {
                        if($cart[$id]['quantity']!=10){
                            $message = 'Product Quantity updated';
                            $cart[$id]['quantity']++;
                        }else{
                            $type= 'warning';
                            $message = 'Maximum Qunatity Reached cant add any more';
                        }
                    } else {
                        $cart[$id] = [
                            "name" => $isProduct->name,
                            "menemonic" => $isProduct->menemonic,
                            "quantity" => $request->quantity ?? 1,
                            "price" => $isProduct->price,
                            "image" => $isProduct->latest_image,
                        ];
                        $message = 'Product added to cart';
                    }
                    session()->put('cart', $cart);
                    $datas = session()->get('cart', []);
                }
                return $this->responseJson(true, 200, $message, $datas);
            } else {
                return $this->responseJson(false, 200, 'Invalid Params provided');
            }
        }
        abort(405);
    }

    public function getGroupedTypes(Request $request){
        if($request->ajax()){
            $id= uuidtoid($request->category,'categories');
            $category= $this->categoryService->findCategoryById($id);
            if($category){
                $categoryGroups= $category->groups;
                return $this->responseJson(true,200,'Groups Found Successfully',ToolGroupResource::collection($categoryGroups));
            }
        }
        abort(405);
    }

    public function updateCart(Request $request)
    {
        if($request->ajax()){
            if($request->id && $request->quantity){
                if(auth()->user()){
                    $product= auth()->user()->carts()->where('product_id',$request->id );
                    if($request->operation=='add'){
                        $product->increment('quantity');
                    }else{
                        $product->decrement('quantity');
                    }
                    $datas= auth()->user()->carts;
                }else{
                    $cart = session()->get('cart');

                    if($request->operation=='add'){
                        if($cart[$request->id]["quantity"]==10) return $this->responseJson(false,200,'Cant add any more',$cart);
                        $cart[$request->id]["quantity"] = $cart[$request->id]["quantity"]+1;
                    }else{
                        if($cart[$request->id]["quantity"]==1) return $this->responseJson(false,200,'Minimum Quantity Reached',$cart);
                        $cart[$request->id]["quantity"] = $cart[$request->id]["quantity"]-1;
                    }
                    session()->put('cart', $cart);
                    $datas= session()->get('cart', []);
                }

                $data = [
                    'data'=> session()->get('cart', []),
                    'cartHtml'=> view('components.frontend.cart-products')->with(['carts' => $datas])->render(),
                    'summaryHtml' => view('components.frontend.cart-summary')->with(['carts' => $datas ])->render(),
                ];

                return $this->responseJson(true,200,"Product Updated Successfully",$data);
            }
        }else{
            abort(403);
        }

    }

    public function removeFromCart(Request $request)
    {
        if($request->ajax()){
            if($request->id) {
                if(auth()->user()){
                   auth()->user()->carts()->where('product_id',$request->id)->delete();
                    $datas= auth()->user()->carts;
                }
                $cart = session()->get('cart',[]);
                if(isset($cart[$request->id])) {
                    unset($cart[$request->id]);
                    session()->put('cart', $cart);
                    $datas= session()->get('cart',[]);
                }
                $data = [
                    'data'=> session()->get('cart', []),
                    'cartHtml'=> view('components.frontend.cart-products')->with(['carts' => $datas ])->render(),
                    'summaryHtml' => view('components.frontend.cart-summary')->with(['carts' => $datas ])->render(),
                ];

                return $this->responseJson(true,200,"Product removed from successfully",$data);
            }
        }else{
            abort(403);
        }
    }

    public function shopByType(Request $request, $type, $slug)
    {

        if ($request->ajax()) {
            $start = ($request->page - 1) * 9;
            if ($type == 'type') {
                $filterConditions = [
                    'tags' => [$slug],
                ];
            } else {
                $id = slugtoid($slug, Str::plural($type));
                $filterConditions = [
                    'brand_id' => $id,
                    'is_active' => true,
                ];
            }
            $products = $this->productService->listProducts($filterConditions, 'id', 'desc', 9, $start);
            if ($products->isNotEmpty()) {
                $data = view('components.frontend.products')->with(['products' => $products])->render();
                return $this->responseJson(true, 200, 'Data Found Successfully', $data);
            }
            return $this->responseJson(false, 200, 'No more data', []);
        }
        abort(405);
    }

}

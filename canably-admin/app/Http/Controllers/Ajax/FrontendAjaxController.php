<?php

namespace App\Http\Controllers\Ajax;

use App\Models\NewsLetter;
use Illuminate\Http\Request;
use App\Services\Blog\BlogService;
use App\Services\User\UserService;
use App\Services\Store\StoreService;
use App\Http\Controllers\BaseController;
use App\Services\Product\ProductService;


class FrontendAjaxController extends BaseController
{
    /**
     * @var ProductService
     */
    protected $productService;
    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var StoreService
     */
    protected $storeService;
    /**
     * @var BlogService
     */
    protected $blogService;

    public function __construct(ProductService $productService,UserService $userService,StoreService $storeService,BlogService $blogService){
        $this->productService = $productService;
        $this->userService = $userService;
        $this->storeService = $storeService;
        $this->blogService = $blogService;
    }

    public function findProducts(Request $request){
        if($request->ajax()){
            $products =[];
            $filterProducts = [
                'is_active' => true
            ];
            if($request->has('category') && $request->category!= 'all'){
                $filterProducts = [
                    'category'=> [$request->category]
                ];
            }

            $isProducts= $this->productService->listProducts($filterProducts,'name');
            if($isProducts->isNotEmpty()){
                foreach ($isProducts as $key => $product) {
                    $products[$key]['name']= $product->title ?? $product->name;
                    $products[$key]['picture']= $product->latest_image;
                    $products[$key]['url']= route('frontend.product.details',$product->uuid);
                    $products[$key]['price']= $product->discounted_price;
                }

            }
            return $this->responseJson(true,200,"Data Found Successfully",$products);
        }else{
            abort(403);
        }
    }

    public function addToCart(Request $request){
        if($request->ajax()){
            $attributes = [];
            $total= 0;
            if($request->has('uuid')){
                $id = uuidtoid($request->uuid,'products');
                $isProduct= $this->productService->findProductById($id);
                $specifications= $isProduct->specifications;
                if($request->has('attributes')){
                    foreach($request->attributes as $attributekey =>$attributevalue){
                        $attributes[$attributekey]['value']= $attributevalue;
                    }
                }else{
                    if(!is_null($specifications)){
                        foreach ($specifications as $key => $value) {
                            $attributes[$key]= array_values($value)[0]['value'];
                            // $attributes['price']= array_values($value)[0]['price'];
                        }
                    }
                    $request->merge(['attributes'=>$attributes,'product_id'=>$id,'quantity'=>1]);
                }
                if(auth()->user()){
                    $isCart= $this->userService->createOrUpdateCart($request->except(['_token','uuid']));
                    $order= session()->get('order-'.auth()->user()->uuid,[]);
                    if(!empty($order)){
                        $discount= $order['discount'] ?? 0;
                    }
                    $datas = auth()->user()->carts;
                    foreach($datas as $product){
                        $total+= $product->product->price * $product->quantity;
                    }
                    $total-= $discount ??0 ;
                    $totalProducts= $datas->count();
                }else{
                    $discount=0;
                    $cart = session()->get('cart', []);
                    $discount= 0;
                    if(isset($cart[$id])) {
                        $cart[$id]['quantity']++;
                    } else {
                        $cart[$id] = [
                            "name" => $isProduct->name,
                            "quantity" => 1,
                            "price" => $isProduct->price,
                            "image" => $isProduct->latest_image,
                            "attributes" => $attributes ?? ''
                        ];
                    }
                    session()->put('cart', $cart);
                    $datas = session()->get('cart', []);
                    foreach($datas as $product){
                        $total+= $product['price'] * $product['quantity'];
                    }
                    $totalProducts= count($datas);
                }
                $data = [
                    'data'=> $datas,
                    'cartHtml'=> view('frontend.components.cart')->with(['cartProducts' => $datas])->render(),
                    'total'=>round($total,2),
                    'discount'=>round($discount ?? 0,2) ?? 0,
                    'totalProducts'=>$totalProducts
                ];
                return $this->responseJson(true,200,'Product added to cart',$data);
            }else{
                return $this->responseJson(false,200,'Invalid Params provided');
            }
        }else{
            abort(403);
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function updateCart(Request $request)
    {
        $total= 0;
        if($request->ajax()){
            if($request->id && $request->quantity){
                if(auth()->user()){
                    $isProductUpdated= auth()->user()->carts()->where('product_id',$request->id )->update([
                        'quantity'=> $request->quantity
                    ]);
                    $datas= auth()->user()->carts;
                    foreach($datas as $product){
                        $total+= $product->product->price * $product->quantity;
                    }
                }else{
                    $cart = session()->get('cart');
                    $cart[$request->id]["quantity"] = $request->quantity;
                    session()->put('cart', $cart);
                    $datas= session()->get('cart', []);
                    foreach($datas as $product){
                        $total+= $product['price'] * $product['quantity'];
                    }
                }

                $data = [
                    'data'=> session()->get('cart', []),
                    'cartHtml'=> view('frontend.components.cart')->with(['cartProducts' => $datas])->render(),
                    'cartDetail'=> view('frontend.components.cart-detailed')->with(['carts' => $datas ])->render(),
                    'total'=>$total
                ];

                return $this->responseJson(true,200,"Product Updated Successfully",$data);
            }
        }else{
            abort(403);
        }

    }

    public function getBlogs(Request $request){
        $search= $request->search;
        $blogs= $this->blogService->listBlogs(['search'=>$search]);
        $data = [
            'searchResult' => view('components.blog-list')->with(['listPopularBlogs' => $blogs])->render(),
        ];
        return $this->responseJson(true, 200, 'Blogs Found Successfully', $data);

    }

    public function removeFromCart(Request $request)
    {
        if($request->ajax()){
            if($request->id) {
                if(auth()->user()){
                    $isCartDeleted = auth()->user()->carts()->where('product_id',$request->id)->delete();
                    $datas= auth()->user()->carts;
                }
                $cart = session()->get('cart');
                if(isset($cart[$request->id])) {
                    unset($cart[$request->id]);
                    session()->put('cart', $cart);
                    $datas= collect(session()->get('cart',[]));
                }
                $data = [
                    'data'=> session()->get('cart', []),
                    'cartHtml'=> view('frontend.components.cart-detailed')->with(['carts' => $datas ])->render()
                ];

                return $this->responseJson(true,200,"Product Removed Successfully",$data);
            }
        }else{
            abort(403);
        }
    }

    public function clearCart(Request $request){
        if($request->ajax()){
            if(auth()->user()){
                $isCartDeleted= auth()->user()->carts()->delete();
                $datas= auth()->user()->carts;
            }else{
                session()->forget('cart');
                $datas= collect(session()->get('cart',[]));
            }
            $data = [
                'data'=> $datas,
                'cartHtml'=> view('frontend.components.cart-detailed')->with(['carts' => $datas ])->render(),
                 /* 'carCount'=> view('frontend.components.cart-detailed')->with(['carts' => $datas ])->render(), */
            ];
            return $this->responseJson(true,200,"Product Removed Successfully",$data);

        }else{
            abort(403);
        }
    }
    public function storePickup(Request $request){
        if($request->ajax()){

            $zip_code = $request->zip;
            /* dd($zip_code); */
            $address = $this->storeService->findZipcode($zip_code);
            if($address->isNotEmpty()){
                return $this->responseJson(true, 200, "Data Available !!", $address);
            }else{
                return $this->responseJson(false, 200, "Data Unvailable !!");

            }



        }else{
            abort(403);
        }
    }

    public function submitNewsLetter(Request $request){
        if($request->ajax()){
            $isNewsLetterUpdatedOrCreated= NewsLetter::updateOrCreate(['email'=>$request->email,'mobile_number'=>$request->mobile_number],$request->except('_token'));
            if($isNewsLetterUpdatedOrCreated){
                $heading= $isNewsLetterUpdatedOrCreated->wasRecentlyCreated ? 'success' : 'info';
                $message= $isNewsLetterUpdatedOrCreated->wasRecentlyCreated ? 'Your Subscription Successfull' : 'Already Subscribed';
                return $this->responseJson(true,200,['heading'=>$heading,'message'=>$message]);
            }
            return $this->responseJson(false,500,'Subscription Unsuccessful');
        }
        abort(405);
    }
}

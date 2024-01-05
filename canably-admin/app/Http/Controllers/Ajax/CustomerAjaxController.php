<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Services\Order\OrderService;
use App\Services\Coupon\CouponService;
use App\Http\Controllers\BaseController;
use App\Services\Product\ProductService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class CustomerAjaxController extends BaseController
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var ProductService
     */
    protected $productService;

    /**
     * @var OrderService
     */
    protected $orderService;
    /**
     * @var CouponService
     */
    protected $couponService;

    public function __construct(UserService $userService, ProductService $productService, OrderService $orderService, CouponService $couponService)
    {
        $this->userService = $userService;
        $this->productService = $productService;
        $this->orderService = $orderService;
        $this->couponService = $couponService;

    }

    public function findAddress(Request $request)
    {
        if ($request->ajax()) {
            $id = uuidtoid($request->uuid, 'addresses');
            $address = $this->userService->findAddress($id);
            return $this->responseJson(true, 200, 'Data Found Successfully', $address);
        } else {
            abort(403);
        }
    }
    public function addAddress(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();

            $request->merge(['created_by' => $user->id, 'updated_by' => $user->id]);

            DB::beginTransaction();
            try {
                if ($request->has('uuid') && $request->uuid != '') {
                    $id = uuidtoid($request->uuid, 'addresses');
                    $isAddress = $this->userService->createOrUpdateAddress($request->except(['_token', 'uuid']), $id);
                } else {
                    $isAddress = $this->userService->createOrUpdateAddress($request->except('_token'));
                }

                if ($isAddress) {
                    DB::commit();
                    $addressData = auth()->user()->addressBook;
                    $data = [
                        'addressHtml' => view('customer.address.components.addreess')->with(['addresses' => $addressData])->render(),
                    ];
                    return $this->responseJson(true, 200, 'Addres added or updated Successfully', $data);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseJson(false, 200, 'Something went wrong');
            }
        } else {
            abort(403);
        }
    }
    public function editAddress(Request $request)
    {
        if ($request->ajax()) {
            $isAddressUpdated = $this->userService->createOrUpdateAddress($request->only('is_default'), $id);
        }
    }
    public function defaultAddress(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();
            $id = uuidtoid($request->uuid, 'addresses');
            $request->merge(['is_default' => 1]);
            DB::beginTransaction();
            try {
                $defaultOtherAddressRemove = auth()->user()->addressBook()->update(['is_default' => false]);
                $isAddressUpdated = $this->userService->createOrUpdateAddress($request->only('is_default'), $id);
                if ($isAddressUpdated) {
                    DB::commit();
                    $addressData = $user->addressBook;
                    $data = [
                        'addressHtml' => view('customer.address.components.addreess')->with(['addresses' => $addressData])->render(),
                    ];
                    return $this->responseJson(true, 200, 'Addres added Successfully', $data);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseJson(false, 200, 'Something went wrong');
            }
        } else {
            abort(403);
        }
    }
    public function deleteAddress(Request $request)
    {
        if ($request->ajax()) {

            $user = auth()->user();
            $id = uuidtoid($request->uuid, 'addresses');

            DB::beginTransaction();
            try {
                $isAddressDeleted = $this->userService->deleteAddress($id);
                if ($isAddressDeleted) {
                    DB::commit();
                    $addressData = $user->addressBook;
                    $data = [
                        'addressHtml' => view('customer.address.components.addreess')->with(['addresses' => $addressData])->render(),
                    ];
                    return $this->responseJson(true, 200, 'Address removed Successfully', $data);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseJson(false, 200, 'Something went wrong');
            }
        } else {
            abort(403);
        }
    }

    public function addToWishlist(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $id = uuidtoid($request->uuid, 'products');
                $productData = $this->productService->findWishlistBYProductId($id);
                //dd($productData->toArray());
                $userWishlist = auth()->user()->wishlists?->pluck('product_id')->toArray();
                //dd($userWishlist);
                if ($userWishlist && !is_null($userWishlist)) {
                    if (in_array($productData->id, $userWishlist)) {
                        $isWishlist = $this->productService->deleteWishlist($id);
                    } else {
                        $isWishlist = $this->productService->createWishlist($request->except('_token'));
                    }
                } else {
                    $isWishlist = $this->productService->createWishlist($request->except('_token'));
                }
                //$isWishlist = $this->productService->createWishlist($request->except('_token'));

                /*  if ($request->has('uuid') && $request->uuid != '') {
                $id = uuidtoid($request->uuid, 'products');
                $isWishlist = $this->productService->createOrDeleteWishlist($request->except(['_token', 'uuid']), $id);
                } else {
                $isWishlist = $this->productService->createOrDeleteWishlist($request->except('_token'));
                } */
                if ($isWishlist) {
                    DB::commit();
                    return $this->responseJson(true, 200, 'Product Added/Removed in wishlist successfully');
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseJson(false, 200, 'Something went wrong');
            }
        } else {
            abort(403);
        }
    }
    public function removeFromWishlist(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();
            $id = uuidtoid($request->uuid, 'products');
            DB::beginTransaction();
            try {
                $isWishlistDeleted = $this->productService->deleteWishlist($id);
                if ($isWishlistDeleted) {
                    DB::commit();
                    $wishlistData = auth()->user()->wishlists;

                    $data = [
                        'wishlistHtml' => view('customer.wishlist.components.wish-list-products')->with(['wishlists' => $wishlistData])->render(),
                    ];
                    return $this->responseJson(true, 200, 'Product removed Successfully', $data);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseJson(false, 200, 'Something went wrong');
            }
        } else {
            abort(403);
        }

    }

    public function getOrdersByType(Request $request)
    {
        if ($request->ajax()) {
            $orders = $this->orderService->getOrdersByStatus($request->only('type'))->sortByDesc('id');
            $data['orders'] = view('customer.order.component.order-card')->with(['orders' => $orders])->render();
            $data['datas'] = $orders;
            return $this->responseJson(true, 200, 'Data found successfully', $data);
        } else {
            abort(403);
        }
    }

    public function applyCouponDiscountCart(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'code' => 'required|string|exists:coupons,code',
            ], [
                'code.required' => 'Please enter a coupon code',
                'code.exists' => 'The coupon code is invalid',
            ]);
            if ($validator->fails()) {
                return $this->responseJson(false, 422, $validator->errors()->all());
            }
            $coupon = $this->couponService->findCouponByCode($request->code);
            if ($coupon) {
                if ($coupon->orders->count() >= $coupon->usage_of_coupon || $coupon->orders()->whereHas('user',function(Builder $query) {
                    $query->where('id',auth()->user()->id);
                })->get()->count() >= $coupon->usage_per_user){
                    return $this->responseJson(false, 200, 'Sorry you cant apply this coupon anymore');
                }
                $carts = auth()->user()->carts;
                // session()->forget('order-' . auth()->user()->uuid);
                if ($carts->isNotEmpty()) {
                    $total = $carts->sum(function ($carts) {
                        return $carts->product->price * $carts->quantity;
                    });
                    if ($coupon->coupon_type == '%') {
                        if($total - round($total * ($coupon->coupon_discount / 100),2)<1){
                            return $this->responseJson(false, 200, 'Sorry Coupon is not applicable');
                        }
                        $discount = $total * round($coupon->coupon_discount / 100,2);
                        $total = $total - round($total * ($coupon->coupon_discount / 100),2);
                    } else {
                        if($total-$coupon->coupon_discount<=0){
                            return $this->responseJson(false, 200, 'Sorry Coupon is not applicable');
                        }
                        $discount = $coupon->coupon_discount;
                        $total = round($total - $coupon->coupon_discount,2);
                    }
                    $discountArray=['discount'=>round($discount,2),'coupon'=>$coupon->id];
                    session()->put(['order-' . auth()->user()->uuid => $discountArray ]);
                    return $this->responseJson(true, 200, 'Coupon applied successfully', ['discount' => round($discount,2), 'total' => round($total,2)]);
                }

            }
            return $this->responseJson(true, 200, 'Coupon found successfully', $coupon);
        }
        abort(405);
    }

    public function removeCartCoupon(Request $request)
    {
        if ($request->ajax()) {
            $carts = auth()->user()->carts;
            if ($carts->isNotEmpty()) {
                $total = $carts->sum(function ($carts) {
                    return $carts->product->price * $carts->quantity;
                });
            }
            session()->put('order-' . auth()->user()->uuid, ['discount' => 0,'total'=>$total,'coupon'=>'']);
            return $this->responseJson(true, 200, 'Coupon Removed',['discount' => 0,'total'=>$total]);
        }
        abort(405);
    }
}

<?php

namespace App\Repositories\Payment;

use App\Models\User\User;
use App\Models\User\Order;
use Illuminate\Support\Str;
use App\Models\Site\PaymentMode;
use App\Models\Site\Transaction;
use App\Models\User\AddressBook;
use App\Models\User\OrderDetail;
use App\Repositories\BaseRepository;
use App\Contracts\Payment\PaymentContract;

/**
 * Class PaymentRepository
 *
 * @package \App\Repositories
 */
class PaymentRepository extends BaseRepository implements PaymentContract
{
    protected $paymentModeModel;
    public function __construct(User $model, PaymentMode $paymentModeModel) {
        parent::__construct($model);
        $this->paymentModeModel = $paymentModeModel;
    }

    public function createOrder(array $attributes)
    {
        // dd($attributes);
        $isAddressCreated= auth()->user()->addressBook()->create([
            'name'=> $attributes['first_name'].' '.$attributes['last_name'],
            'phone_number'=> $attributes['phone_number'],
            'full_address'=>$attributes['full_address'],
            'zip_code'=>$attributes['zip_code'],
            'type'=>$attributes['type'] ?? 'home',
            'country_id'=>$attributes['country_id'],
            'state_id'=>$attributes['state_id'],
            'city_id'=>$attributes['city_id'],
        ]);
        // dd('here');
        if($isAddressCreated){
            $isOrderCreated = $this->create([
                'user_id' => auth()->user()->id,
                'address_book_id'=> $isAddressCreated->id,
                'note'=> $attributes['note'],
            ]);
            // dd('here');
            if ($isOrderCreated) {
                $carts = auth()->user()->carts;
                $totalPrice = 0;
                foreach ($carts as $cart) {
                    $isOrderCreated->details()->create([
                        'product_id' => $cart->product_id,
                        'additional_details' => $cart->product,
                        'attributes' => $cart->attributes,
                        'shipping_cost' => 0,
                        'price' => $cart->product->list_price,
                        'discounted_price' => $cart->product->special_price ?? $cart->product->list_price,
                        'quantity' => $cart->quantity,
                    ]);
                    $totalPrice = $totalPrice + $cart->product->special_price ?? $cart->product->list_price;
                }
                // dd('here');
                $isOrderCreated->orderTransaction()->create([
                    'user_id' => auth()->user()->id,
                    'order_id' => $isOrderCreated->id,
                    'amount' => $totalPrice,
                    'currency' => 'usd',
                    'payment_gateway' => 'bypassed',
                    'payment_gateway_id' => random_int(1,100000),
                    'json_response' => [],
                    'payment_gateway_uuid' => Str::uuid(),
                    'status' => true,
                ]);
                auth()->user()->carts()->delete();
            }
            return $isOrderCreated;
        }


        return false;
    }
    public function listPaymentModes($filterConditions,string $order = 'id', string $sort = 'desc',$limit= null,$inRandomOrder= false){
        $paymentModes = $this->paymentModeModel->all();
        if(!is_null($limit)){
            return $paymentModes->paginate($limit);
        }
        return $paymentModes;
    }
}

<?php

namespace App\Repositories\Payment;

// use Omnipay\Omnipay;
use App\Contracts\Payment\PaymentContract;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderDetail;
use App\Models\Store;
use App\Models\StoreDelivery;
use App\Models\Transaction;
use App\Repositories\BaseRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Omnipay\Omnipay;

/**
 * Class PaymentRepository
 *
 * @package \App\Repositories
 */
class PaymentRepository extends BaseRepository implements PaymentContract
{
    protected $model;

    protected $orderAddressModel;

    protected $odrederDetailsModel;

    protected $transactionModel;

    protected $gateway;

    protected $storeDeliveryModel;
    protected $storeModel;

    public function __construct(
        Order $model,
        Store $storeModel,
        OrderAddress $orderAddressModel,
        OrderDetail $odrederDetailsModel,
        Transaction $transactionModel,
        StoreDelivery $storeDeliveryModel
    ) {
        parent::__construct($model);
        $this->orderAddressModel = $orderAddressModel;
        $this->odrederDetailsModel = $odrederDetailsModel;
        $this->transactionModel = $transactionModel;
        $this->storeDeliveryModel = $storeDeliveryModel;
        $this->storeModel = $storeModel;
        $this->gateway = Omnipay::create('AuthorizeNetApi_Api');
        $this->gateway->setAuthName(config('constants.AUTHORIZE_LOGINID'));
        $this->gateway->setTransactionKey(config('constants.AUTHORIZE_TRANSACTION_KEY'));
        $this->gateway->setTestMode(true);
    }

    public function createOrder(array $attributes)
    {
        // dd($attributes);
        $odoData = collect([]);
        $odoData = $odoData->merge(['jsonrpc' => '2.0']);
        $odoData = $odoData->merge(['params' => [
            "api_key" => "f73a5f039c3a6b315fdaaec0846f913c",
            "customer_name" => auth()->user()->full_name,
            "mobile" => auth()->user()->mobile_number,
            "email" => auth()->user()->email,
            "date_order" => Carbon::now()->format('Y-m-d'),
        ]]);
        $isOrderCreated = $this->create([
            'user_id' => auth()->user()->id,
            'delivery_status' => false,
            'discount' => $attributes['order']['discount'] ?? 0,
            'delivery_type' => $attributes['order']['delivery_type'] == 'store-pickup' ? 'store_pick' : 'delivery',
            'delivered_at' => Carbon::now()->addDays(10)->format('Y-m-d H:i:s'),
            'status_description' => [
                'confirmed' => [
                    'status' => true, 'comment' => 'Order Placed', 'time' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                'packed' => [
                    'status' => false, 'comment' => 'Order Packed', 'time' => '',
                ],
                'shipped' => [
                    'status' => false, 'comment' => 'Order Placed', 'time' => '',
                ],
                'outfordelivery' => [
                    'status' => false, 'comment' => 'Order Out For Delivery', 'time' => '',
                ],
                'delivered' => [
                    'status' => false, 'comment' => 'Order Delivered', 'time' => '',
                ],
                'cancelled' => [
                    'status' => false, 'comment' => 'Order Cancelled', 'time' => '',
                ],
                'returned' => [
                    'status' => false, 'comment' => 'Order Returned', 'time' => '',
                ],
            ],
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);
        if ($isOrderCreated) {
            if ($attributes['order']['coupon']) {
                $isOrderCreated->coupons()->attach($attributes['order']['coupon']);
            }
            $carts = auth()->user()->carts;
            $price = 0;
            $attributePrice = 0;
            $totalPrice = 0;
            foreach ($carts as $cartKey => $cart) {
                $cartAttributes = $cart->attributes;
                if (!is_null($cartAttributes)) {
                    foreach ($cartAttributes as $key => $value) {
                        $foundedPrice = attributePrice($value, $cart->product_id);
                        $attributePrice = $attributePrice < $foundedPrice ? $foundedPrice : $attributePrice;
                    }
                }
                // $price = $price + ($attributePrice > 0 ? $attributePrice - ($attributePrice * ($cart->product->discount / 100)) : $cart->product->price);
                // $price
                // $discountedPrice = $price - ($price * ($cart->product->discount / 100));
                $isOrderDetailsCreated = $isOrderCreated->details()->create([
                    'product_id' => $cart->product_id,
                    'additional_details' => $cart->product,
                    'attributes' => $cart->attributes,
                    'shipping_cost' => $attributes['order']['shipping_cost'] ?? 0,
                    'price' => $cart->product->price,
                    'discounted_price' => $cart->product->discounted_price,
                    'vendor_id' => $cart->product->vendor_id,
                    'quantity' => $cart->quantity,
                ]);
                $totalPrice = $totalPrice + $cart->product->price;
                $odoProduct = $cart->product;
                $odoData = $odoData->mergeRecursive(['params' => [
                    'order_line' => [$cartKey => [
                        'product_name' => $odoProduct->name,
                        'name' => $odoProduct->desciption,
                        'product_uom_qty' => $cart->quantity,
                        'price_unit' => $cart->product->discounted_price,
                    ],
                    ],
                ]]);
            }
            $totalPrice = $totalPrice + ($attributes['order']['shipping_cost'] ?? 0) - ($attributes['order']['discount'] ?? 0);
            if ($attributes['order']['delivery_type'] == 'delivery') {
                $isOrderAddressCreated = $isOrderCreated->orderAddress()->create([
                    'full_address' => $attributes['order']['address']['full_address'],
                    'zip_code' => $attributes['order']['address']['zip_code'],
                    'name' => $attributes['order']['address']['name'],
                    'phone_number' => $attributes['order']['address']['phone_number'],
                ]);
                $country = customfind($attributes['order']['country'], 'countries');
                $city = customfind($attributes['order']['city'], 'cities');
                $odoData = $odoData->mergeRecursive(['params' => [
                    'street' => $attributes['order']['address']['street_address'] ?? '',
                    'zip' => $attributes['order']['address']['zip_code'] ?? '',
                    'country' => $country?->name ?? 'United States',
                    'city' => $city?->name ?? '',
                ]]);
            }
            if ($attributes['order']['delivery_type'] == 'store-pickup') {
                $storeId = uuidtoid($attributes['order']['store_address'], 'stores');
                $store = $this->storeModel->find($storeId);

                $isOrderCreated->orderStore()->create([
                    'store_id' => $storeId,
                    'delivery_status' => false,
                ]);
                $odoData = $odoData->mergeRecursive(['params' => [
                    'zip' => $store->zip_code ?? '',
                    'country' => $store->full_address ?? '',
                    'city' => $store->full_address ?? '',
                    'street' => $store->full_address ?? '',
                ]]);
            }
            /* $isTransactionCreated = $isOrderCreated->orderTransaction()->create([
            'user_id' => auth()->user()->id,
            'ammount' => $totalPrice,
            'currency' => 'usd',
            'transactionable_type' => get_class($isOrderCreated),
            'transactionable_id' => $isOrderCreated->id,
            'payment_gateway'=>'bypassed',
            'json_response'=> [],
            'payment_gateway_id'=>rand(6,10).'-'.now(),
            'payment_gateway_uuid'=>Str::uuid(),
            'status' => true,
            ]); */

            if (isset($attributes['opaqueDataDescriptor']) && isset($attributes['opaqueDataValue'])) {
                // dd($attributes);
                /* authorize.net value not initiated so commented out the parts */
                $transationId = 'tr-' . rand(100000000, 999999999);
                $response = $this->gateway->authorize([
                    'amount' => $totalPrice,
                    'currency' => 'USD',
                    'transactionId' => $transationId,
                    'opaqueDataDescriptor' => $attributes['opaqueDataDescriptor'],
                    'opaqueDataValue' => $attributes['opaqueDataValue'],
                ])->send();
                Log::channel('payment')->error(json_encode($response));
                if ($response->isSuccessful()) {
                    $transactionReference = $response->getTransactionReference();
                    $CaptureResponse = $this->gateway->capture([
                        'amount' => $totalPrice,
                        'currency' => 'USD',
                        'transactionReference' => $transationId,
                    ])->send();
                    Log::channel('payment')->error(json_encode($CaptureResponse));
                    // Insert transaction data into the database
                    $isTransactionCreated = $isOrderCreated->orderTransaction()->create([
                        'user_id' => auth()->user()->id,
                        'ammount' => $totalPrice,
                        'currency' => 'usd',
                        'transactionable_type' => get_class($isOrderCreated),
                        'transactionable_id' => $isOrderCreated->id,
                        'payment_gateway' => 'authorize.net',
                        'json_response' => json_decode(json_encode($response, true)),
                        'payment_gateway_id' => rand(6, 10) . '-' . now(),
                        'payment_gateway_uuid' => $transationId,
                        'status' => true,
                    ]);
                } else {
                    Log::channel('payment')->error(json_encode($response));
                    return false;
                }
            }
            $isOdoDataCreated = $this->sendDataToOdo($odoData->toArray());
            if (!$isOdoDataCreated) {
                return false;
            }
            auth()->user()->carts()->delete();
            session()->forget('order-' . auth()->user()->uuid);
            session()->put('order_id', $isOrderCreated->order_no);
        }
        return $isOrderCreated;
    }
    /* public function createOrder(array $attributes)
    {

    $input = $attributes;
    $merchantAuthentication = new MerchantAuthenticationType();
    $merchantAuthentication->setName(config('constants.AUTHORIZE_LOGINID'));
    $merchantAuthentication->setTransactionKey(config('constants.AUTHORIZE_TRANSACTION_KEY'));
    $refId = 'ref' . time();
    $creditCard = new CreditCardType();
    $creditCard->setCardNumber(preg_replace('/\s+/', '', $input['card-number']));
    $creditCard->setExpirationDate($input['expiry-year'] . "-" . $input['expiry-month']);
    $creditCard->setCardCode($input['card-cvc']);
    $paymentOne = new PaymentType();
    $paymentOne->setCreditCard($creditCard);

    $transactionRequestType = new TransactionRequestType();
    $transactionRequestType->setTransactionType("authCaptureTransaction");
    $transactionRequestType->setAmount(27);
    $transactionRequestType->setPayment($paymentOne);

    $requests = new CreateTransactionRequest();
    $requests->setMerchantAuthentication($merchantAuthentication);
    $requests->setRefId($refId);
    $requests->setTransactionRequest($transactionRequestType);
    dump($requests);
    $controller = new CreateTransactionController($requests);
    $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
    Log::channel('payment')->error(json_encode($response));
    if ($response != null) {
    if ($response->getMessages()->getResultCode() == "Ok") {
    $tresponse = $response->getTransactionResponse();
    if ($tresponse != null && $tresponse->getMessages() != null) {
    $message_text = $tresponse->getMessages()[0]->getDescription() . ", Transaction ID: " . $tresponse->getTransId();
    $msg_type = "success_msg";
    } else {
    $message_text = 'There were some issue with the payment. Please try again later.';
    $msg_type = "error_msg";

    if ($tresponse->getErrors() != null) {
    $message_text = $tresponse->getErrors()[0]->getErrorText();
    $msg_type = "error_msg";
    }
    }

    } else {
    $message_text = 'There were some issue with the payment. Please try again later.';
    $msg_type = "error_msg";

    $tresponse = $response->getTransactionResponse();

    if ($tresponse != null && $tresponse->getErrors() != null) {
    $message_text = $tresponse->getErrors()[0]->getErrorText();
    $msg_type = "error_msg";
    } else {
    $message_text = $response->getMessages()->getMessage()[0]->getText();
    $msg_type = "error_msg";
    }
    }
    } else {
    dd('error');
    }
    } */

    public function sendDataToOdo(array $data)
    {
        $odoUrl = config('constants.ODO_LIVE_URL') . 'create/saleorder';
        $response = Http::post($odoUrl, $data);
        Log::channel('payment')->info($response->body());
        if ($response->ok()) {
            return true;
        }
        return false;
    }
}

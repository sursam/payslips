<?php

namespace App\Http\Controllers\Api;

use App\Mail\SendMailable;
use App\Traits\UploadAble;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\Order\OrderService;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Api\UserResource;
use App\Http\Resources\EarningsResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Api\DeliveriesResource;
use App\Http\Resources\Api\BankDetailsResource;
use App\Http\Resources\Api\NotificationResource;

class AgentController extends BaseController
{
    use UploadAble;
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function acceptOrReject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'required|uuid|exists:orders,uuid',
            'status' => 'required|boolean',
            'comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->all(), "");
        }

        DB::beginTransaction();
        try {
            $id = uuidtoid($request->uuid, 'orders');
            $order = $this->orderService->findOrder($id);
            if ($order) {
                $updateArray = [];
                $deliveryStatusChange = auth()->user()->deliveries()->where('order_id', $id)->whereNull('rejected_at')->first();
                if ($request->status) {
                    $description = $order->status_description;
                    $description['packed']['status'] = true;
                    if ($request->has('comment')) {
                        $description['packed']['comment'] = $request->comment;
                    }
                    $updateArray = [
                        'delivery_status' => true,
                        'status_description' => $description,
                    ];
                    $statusArray = ['accepted_at' => Carbon::now()];
                } else {
                    $updateArray = [
                        'delivery_status' => false,
                    ];
                    $statusArray = ['rejected_at' => Carbon::now()];
                }
                $deliveryStatusChange = $deliveryStatusChange->update($statusArray);
                $isOrderUpdated = $order->update($updateArray);
            }
            if ($deliveryStatusChange && $isOrderUpdated) {
                DB::commit();
                return $this->responseJson(true, 200, 'Delivery status changed successfully', []);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }

    }

    public function deliveries(Request $request, $status)
    {
        $validator = Validator::make(['status' => $status], [
            'status' => 'required|string|in:all,current,upcoming,completed',
        ]);

        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->all(), "");
        }
        $deliveries = auth()->user()->deliveries()->whereNull('rejected_at');
        switch ($status) {
            case 'upcoming':
                $deliveries = $deliveries->whereNull('accepted_at')->where(['is_completed' => false]);
                break;
            case 'completed':
                $deliveries = $deliveries->whereNotNull('accepted_at')->where(['is_completed' => true]);
                break;
            case 'current':
                $deliveries = $deliveries->whereNotNull('accepted_at')->where(['is_completed' => false]);
                break;
        }
        $deliveries = $deliveries->get()->sortByDesc('id');
        $message = $deliveries->isNotEmpty() ? 'Deliveries found successfully' : 'No deliveries found';
        return $this->responseJson(true, 200, $message, DeliveriesResource::collection($deliveries));
    }

    public function changeDeliveryStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'required|uuid|exists:orders,uuid',
            'status' => 'required|string|in:shipped,outfordelivery,delivered',
            'otp' => 'required_if:status,delivered|integer',
            'resend' => 'sometimes|string',
            'comment' => 'nullable|string',
        ]);
        if ($validator->fails()) {return $this->responseJson(false, 422, $validator->errors()->all(), (object) []);}
        DB::beginTransaction();
        try {
            $id = uuidtoid($request->uuid, 'orders');
            $order = $this->orderService->findOrder($id);
            if ($order) {
                if ($request->has('otp') && $request->otp != $order->delivery_otp) {
                    return $this->responseJson(false, 200, 'Delivery OTP does not matched');
                }
                $description = $order->status_description;
                $description[$request->status]['status'] = true;
                $description[$request->status]['time'] = Carbon::now()->format('Y-m-d H:i:s');
                if ($request->has('comment')) {
                    $description[$request->status]['comment'] = $request->comment;
                }
                $status = $request->status == 'shipped' ? 2 : ($request->status == 'outfordelivery' ? 3 : 4);
                $updateArray = collect([
                    'status_description' => $description,
                    'delivery_status' => $status,
                ]);
                if ($request->status == 'outfordelivery') {
                    $updateArray = $updateArray->merge(['delivery_otp' => genrateOtp()]);
                }
                if ($request->status == 'delivered') {
                    auth()->user()->deliveries()->where('order_id', $id)->update(['is_completed' => true]);
                }
                $isOrderUpdated = $order->update($updateArray->toArray());
                if ($isOrderUpdated) {
                    DB::commit();
                    if ($request->status == 'outfordelivery') {
                        $mailParams = array();
                        $mailParams['mail_type'] = 'agent_forget_password';
                        $mailParams['to'] = $order->user->email;
                        $mailParams['from'] = config('mail.from.address');
                        $mailParams['subject'] = 'Delivery OTP- Canably Order';
                        $mailParams['header'] = 'Delivery OTP';
                        $mailParams['greetings'] = "Hello ! User";
                        $mailParams['line'] = 'Please use this otp for verify the delivery';
                        $mailParams['otp'] = $order->delivery_otp;
                        $mailParams['end_greetings'] = "Regards,";
                        $mailParams['from_user'] = env('MAIL_FROM_NAME');
                        Mail::send(new SendMailable($mailParams));
                    }
                    $message = $request->has('resend') ? 'OTP resend successfully' : 'Delivery status changed successfully';
                    return $this->responseJson(true, 200, $message, new DeliveriesResource(auth()->user()->deliveries()->where('order_id', $id)->first()));
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), (object) []);
        }

    }

    public function getProfile(Request $request)
    {
        return $this->responseJson(true, 200, 'Profile found successfully', new UserResource(auth()->user()));
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string',
            'zipcode' => 'required|numeric',
            'image' => 'sometimes|image|mimes:png,jpg',
            'driving_licence' => 'sometimes|image|mimes:png,jpg',
        ]);
        if ($validator->fails()) {return $this->responseJson(false, 422, $validator->errors()->all(), (object) []);}
        DB::beginTransaction();
        try {
            $isUserUpdated = auth()->user()->profile()->update($request->only(['address', 'zipcode']));
            if ($isUserUpdated) {
                if ($request->has('image')) {
                    $fileName = uniqid() . '.' . $request->image->getClientOriginalExtension();
                    $isFileUploaded = $this->uploadOne($request->image, config('constants.SITE_PROFILE_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                    if ($isFileUploaded) {
                        $isFileRelatedMediaCreated = auth()->user()->media()->updateOrCreate(['is_profile_picture' => true], [
                            'mediaable_type' => get_class(auth()->user()),
                            'mediaable_id' => auth()->user()->id,
                            'media_type' => 'image',
                            'file' => $fileName,
                            'is_profile_picture' => true,
                        ]);
                    }
                }
                if ($request->has('driving_licence')) {
                    $documentName = uniqid() . '.' . $request->driving_licence->getClientOriginalExtension();
                    $isFileUploaded = $this->uploadOne($request->driving_licence, config('constants.SITE_AGENT_DOCUMENT_UPLOAD_PATH'), $documentName, 'public');
                    if ($isFileUploaded) {
                        $isFileRelatedMediaCreated = auth()->user()->document()->updateOrCreate(['title' => 'Driving Licence'], [
                            'mediaable_type' => get_class(auth()->user()),
                            'mediaable_id' => auth()->user()->id,
                            'document_type' => 'Licence Document',
                            'file' => $documentName,
                            'status' => false,
                        ]);
                    }
                }
                DB::commit();
                return $this->responseJson(true, 200, 'Profile updated successfully', new UserResource(auth()->user()));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), (object) []);
        }
    }

    public function orderDetails(Request $request, $uuid)
    {
        $validator = Validator::make(['uuid' => $uuid], [
            'uuid' => 'required|uuid|exists:orders,uuid',
        ]);
        if ($validator->fails()) {return $this->responseJson(false, 422, $validator->errors()->all(), (object) []);}
        $id = uuidtoid($request->uuid, 'orders');
        return $this->responseJson(true, 200, 'Order details found sucessfully', new DeliveriesResource(auth()->user()->deliveries()->where('order_id', $id)->first()));
    }

    public function getBankDetails(Request $request)
    {

        if (!auth()->user()->account) {
            return $this->responseJson(false, 200, 'No Bank Details Found', (object) []);
        }

        return $this->responseJson(true, 200, 'Bank Details Found', new BankDetailsResource(auth()->user()->account));
    }

    public function updateBankDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'ach' => 'required|string',
            'bank' => 'required|string',
            'account' => 'required|string|confirmed',
        ]);
        if ($validator->fails()) {return $this->responseJson(false, 422, $validator->errors()->all(), (object) []);}
        DB::beginTransaction();
        try {
            $isUserDetailsUpdated = auth()->user()->account()->updateOrcreate(['user_id' => auth()->user()->id], $request->except('account_confirmation'));
            if ($isUserDetailsUpdated) {
                DB::commit();
                return $this->responseJson(true, 200, 'Bank Details Updated Successfully', new BankDetailsResource(auth()->user()->account));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), (object) []);
        }

    }

    public function earnings(Request $request)
    {
        return $this->responseJson(true, 200, 'Earnings found successfully', ['total_earning'=>auth()->user()->total_earning,'earnings'=>EarningsResource::collection(auth()->user()->earnings->where('is_approve', true))]);
    }

    public function notifications(){
        $notifications=auth()->user()->notifications()->get();
        return $this->responseJson(true,200,'Notifications found successfully',NotificationResource::collection($notifications));
    }
    public function readNotifications(Request $request){
        if($request->has('id')){
            auth()->user()->unreadNotifications->where('id',$request->id)->markAsRead();
        }else{
            auth()->user()->unreadNotifications->markAsRead();
        }
        $notifications= auth()->user()->notifications()->get();
        return $this->responseJson(true,200,'Notifications found succesfully',NotificationResource::collection($notifications));
    }
    public function delteNotification(Request $request){
        $isNotificationDeleted= auth()->user()->notifications()->where('id',$request->id)->delete();
        $message= $isNotificationDeleted ? 'Notification deleted successfully' : 'Notification delete unscessfull';
        $notifications= auth()->user()->notifications()->get();
        return $this->responseJson(true,200,$message,NotificationResource::collection($notifications));
    }
}

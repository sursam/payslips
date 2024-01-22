<?php

namespace App\Http\Controllers\Ajax;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Site\Media;
use App\Models\module\Pitch;
use Illuminate\Http\Request;
use App\Models\Module\Module;
use App\Services\Faq\FaqService;
use App\Models\Module\ModuleField;
use App\Services\Fare\FareService;
use App\Services\Page\PageService;
use App\Services\User\UserService;
use App\Services\Zone\ZoneService;
use Illuminate\Support\Facades\DB;
use App\Models\Module\ApplicationForm;
use App\Notifications\SiteNotification;
use App\Services\Location\StateService;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Api\UserResource;
use App\Services\Booking\BookingService;
use App\Services\Company\CompanyService;
use App\Services\Fare\HelperFareService;
use App\Services\Medical\MedicalService;
use App\Services\Support\SupportService;
use App\Services\Vehicle\VehicleService;
use App\Services\Category\CategoryService;
use App\Notifications\SendPushNotification;
use App\Services\Role\RolePermissionService;
use App\Services\Transaction\TransactionService;
use App\Services\Subscription\SubscriptionService;

class AjaxController extends BaseController
{

    public function __construct(
        protected PageService $pageService,
        protected FaqService $faqService,
        protected SupportService $supportService,
        protected FareService $fareService,
        protected HelperFareService $helperFareService,
        protected CategoryService $categoryService,
        protected StateService $stateService,
        protected SubscriptionService $subscriptionService,
        protected UserService $userService,
        protected RolePermissionService $rolePermissionService,
        protected CompanyService $companyService,
        protected VehicleService $vehicleService,
        protected ZoneService $zoneService,
        protected TransactionService $transactionService,
        protected BookingService $bookingService,
        protected MedicalService $medicalService,
    ) {
        $this->categoryService = $categoryService;
        $this->pageService = $pageService;
        $this->faqService = $faqService;
        $this->supportService = $supportService;
        $this->stateService = $stateService;
        $this->userService = $userService;
        $this->rolePermissionService = $rolePermissionService;
        $this->subscriptionService = $subscriptionService;
        $this->vehicleService = $vehicleService;
        $this->zoneService = $zoneService;
        $this->transactionService = $transactionService;
        $this->bookingService = $bookingService;
        $this->medicalService = $medicalService;
    }

    public function updateProfile(Request $request)
    {
        if ($request->ajax()) {
        }
        abort(405);
    }

    public function getPages(Request $request)
    {
        if ($request->ajax()) {
            try {
                $totalData = $this->pageService->getTotalData();
                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = 'id';
                $dir = 'desc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (empty($request->input('search.value'))) {
                    $pages = $this->pageService->getListofPages($start, $limit, $order, $dir);
                } else {
                    $search = $request->input('search.value');
                    $pages = $this->pageService->getListofPages($start, $limit, $order, $dir, $search);
                    $totalFiltered = $this->pageService->getTotalData($search);
                }
                if (!empty($pages)) {

                    foreach ($pages as $page) {
                        $status = '';
                        if ($page->is_active) {
                            $status = 'checked';
                        }
                        $index++;
                        $nestedData['sr'] = '<p>' . $index . '</p>';
                        $nestedData['id'] = $index;
                        $nestedData['name'] = $page->name;
                        $nestedData['title'] = $page->title;
                        $nestedData['slug'] = $page->slug;
                        $nestedData['status'] = '<div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                        <input id="switch' . $page->uuid . '" class="show-code form-check-input mr-0 ml-3 changeStatus" type="checkbox" name="is_active"' . $status . ' data-uuid="' . $page->uuid . '" data-table="pages" data-message="deactive">
                        </div>';

                        $nestedData['action'] = '<div class="flex justify-center items-center"><a class="flex items-center mr-3" href="' . route('admin.cms.page.edit', $page->uuid) . '"><span class="icon text-white-50 mr-1"><i class="fas fa-edit"></i></span><span class="text">Edit</span></a><a class="flex items-center text-danger deleteData" href="javascript:;" data-table="pages" data-uuid="' . $page->uuid . '"><span class="icon text-white-50 mr-1"><i class="fas fa-trash"></i></span><span class="text">Delete</span></a></div>';
                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }
    public function getRoles(Request $request)
    {
        if ($request->ajax()) {
            try {
                $totalData = $this->rolePermissionService->getTotalData();
                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = 'id';
                $dir = 'desc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (empty($request->input('search.value'))) {
                    $roles = $this->rolePermissionService->getList($start, $limit, $order, $dir);
                } else {
                    $search = $request->input('search.value');
                    $roles = $this->rolePermissionService->getList($start, $limit, $order, $dir, $search);
                    $totalFiltered = $this->rolePermissionService->getTotalData($search);
                }
                if (!empty($roles)) {
                    foreach ($roles as $role) {
                        $index++;
                        $nestedData['sr'] = '<p>' . $index . '</p>';
                        $nestedData['id'] = $index;
                        $nestedData['name'] = $role->name;
                        $nestedData['slug'] = $role->slug;

                        $nestedData['action'] = '<div class="flex justify-center items-center"><a href="' . route('admin.settings.role.attach.permission', $role->id) . '" class="flex items-center mr-3"><span class="icon text-white-50"><i class="fas fa-paperclip mr-1"></i></span><span class="text">Permissions</span></a></div>';

                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }

    public function getCategories(Request $request)
    {
        if ($request->ajax()) {
            try {
                $type = $request->input('type');
                $filterConditions = [
                    'type' => $type
                ];
                $totalData = $this->categoryService->getTotalData($filterConditions);
                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = 'id';
                $dir = 'desc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (empty($request->input('search.value'))) {
                    $categories = $this->categoryService->getListofCategories($filterConditions, $start, $limit, $order, $dir);
                } else {
                    $search = $request->input('search.value');
                    $categories = $this->categoryService->getListofCategories($filterConditions, $start, $limit, $order, $dir, $search);
                    $totalFiltered = $this->categoryService->getTotalData($search);
                }

                if (!empty($categories)) {
                    $editRoute = '';
                    switch ($type) {
                        case 'business':
                            $editRoute = 'admin.settings.categories.edit';
                            break;
                        case 'objective':
                            $editRoute = 'admin.settings.objectives.edit';
                            break;
                        case 'eligibility':
                            $editRoute = 'admin.settings.eligibilities.edit';
                            break;
                        case 'document':
                            $editRoute = 'admin.settings.documents.edit';
                            break;
                        case 'referral':
                            $editRoute = 'admin.referral.type.edit';
                            break;
                        case 'doctor_level':
                            $editRoute = 'admin.medical.doctor.level.edit';
                            break;
                    }
                    foreach ($categories as $category) {
                        $status = $category->is_active == true ? 'checked' : '';
                        $index++;
                        $nestedData['sr'] = '<p>' . $index . '</p>';
                        $nestedData['id'] = $index;
                        $nestedData['name'] = $category->name;

                        $nestedData['status'] = '<div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                        <input id="switch' . $category->uuid . '" class="show-code form-check-input mr-0 ml-3 changeStatus" type="checkbox" name="is_active"' . $status . ' data-uuid="' . $category->uuid . '" data-table="categories" data-message="deactive">
                        </div>';

                        //$nestedData['status'] = '<div class="custom-control custom-switch inTable"><input type="checkbox" class="custom-control-input changeStatus" id="switch' . $category->uuid . '" name="is_active"' . $status . ' data-uuid="' . $category->uuid . '" data-table="categories" data-message="deactive" ><label class="custom-control-label" for="switch' . $category->uuid . '"  ></label></div>';

                        $nestedData['action'] =
                            '<div class="flex"><a href="' . route($editRoute, $category->uuid) . '" class="flex items-center mr-3">
                            <span class="icon text-white-50"><i class="fas fa-edit"></i></span>
                            <span class="text">Edit</span>
                        </a>
                        <a href="javascript:void(0)" class="flex items-center text-danger deleteData" data-table="categories" data-uuid="' . $category->uuid . '">
                            <span class="icon text-white-50"><i class="fas fa-trash"></i></span>
                            <span class="text">Delete</span>
                        </a></div>';

                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }

    /*public function getOrders(Request $request)
    {
        if ($request->ajax()) {
            try {
                $totalData = $this->orderService->getTotalData();
                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = 'id';
                $dir = 'desc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (empty($request->input('search.value'))) {
                    $orders = $this->orderService->getOrders($start, $limit, $order, $dir);
                } else {
                    $search = $request->input('search.value');
                    $orders = $this->orderService->getOrders($start, $limit, $order, $dir, $search);
                    $totalFiltered = $this->orderService->getTotalData($search);
                }

                if (!empty($orders)) {
                    foreach ($orders as $order) {
                        $nestedData['delivery_status'] = $order->delivery_status == 0 ? 'Confirmed' : ($order->delivery_status == 1 ? 'Packed' : ($order->delivery_status == 2 ? 'Shipped' : ($order->delivery_status == 3 ? 'Out for delivery' : ($order->delivery_status == 4 ? 'Delivered' : 'Cancelled'))));
                        $index++;
                        $nestedData['sr'] = $index;
                        $nestedData['id'] = $index;
                        $nestedData['order_no'] = $order->order_no;
                        $nestedData['user'] = $order->user->full_name;

                        $nestedData['action'] =
                            '<div class="d-flex">
                            <div class="col-12">
                                <a href="' . route('admin.order.user.find', $order->uuid) . '" class="btn btn-sm btn-primary btn-icon-split text-nowrap">
                                    <span class="icon text-white-50"><i class="fas fa-eye"></i></span>
                                    <span class="text">View Details</span>
                                </a>
                            </div>
                        </div>';

                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }

    public function getProducts(Request $request)
    {
        if ($request->ajax()) {
            try {
                $totalData = $this->productService->getTotalData();
                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = 'id';
                $dir = 'desc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (empty($request->input('search.value'))) {
                    $products = $this->productService->getListofProducts($start, $limit, $order, $dir);
                } else {
                    $search = $request->input('search.value');
                    $products = $this->productService->getListofProducts($start, $limit, $order, $dir, $search);
                    $totalFiltered = $this->productService->getTotalData($search);
                }

                if (!empty($products)) {
                    foreach ($products as $product) {
                        $status = $product->is_active == true ? 'checked' : '';
                        $index++;
                        $nestedData['sr'] = '<p>' . $index . '</p>';
                        $nestedData['id'] = $index;
                        $nestedData['name'] = $product->name;
                        $nestedData['brand'] = $product->brand->name;
                        $nestedData['category'] = $product->category->name;
                        $nestedData['price'] = $product->price;

                        $nestedData['status'] = '<div class="custom-control custom-switch inTable"><input type="checkbox" class="custom-control-input changeStatus" id="switch' . $product->uuid . '" name="is_active"' . $status . ' data-uuid="' . $product->uuid . '" data-table="products" data-message="deactive" ><label class="custom-control-label" for="switch' . $product->uuid . '"  ></label></div>';

                        $nestedData['action'] =
                            '<div class="d-flex">
                            <div class="col-6">
                                <a href="' . route('admin.inventories.products.edit', $product->uuid) . '" class="btn btn-sm btn-primary btn-icon-split">
                                    <span class="icon text-white-50"><i class="fas fa-edit"></i></span>
                                    <span class="text">Edit</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger btn-icon-split deleteData" data-table="products" data-uuid="' . $product->uuid . '">
                                    <span class="icon text-white-50"><i class="fas fa-trash"></i></span>
                                    <span class="text">Delete</span>
                                </a>
                            </div>
                        </div>';

                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }*/

    public function getMemberships(Request $request)
    {
        if ($request->ajax()) {
            try {
                $totalData = $this->subscriptionService->getTotalData();
                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = 'id';
                $dir = 'desc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (empty($request->input('search.value'))) {
                    $memberships = $this->subscriptionService->getList($start, $limit, $order, $dir);
                } else {
                    $search = $request->input('search.value');
                    $memberships = $this->subscriptionService->getList($start, $limit, $order, $dir, $search);
                    $totalFiltered = $this->subscriptionService->getTotalData($search);
                }

                if (!empty($memberships)) {
                    foreach ($memberships as $membership) {
                        $status = $membership->is_active == true ? 'checked' : '';
                        $index++;
                        $nestedData['sr'] = '<p>' . $index . '</p>';
                        $nestedData['id'] = $index;
                        $nestedData['name'] = $membership->name;
                        $nestedData['duration'] = $membership->price->duration;
                        $nestedData['price'] = $membership->price->price;
                        $nestedData['active-users'] = $membership->subscribedUsers()->where(['is_expired' => false])->count();

                        $nestedData['status'] = '<div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0"><input id="switch' . $membership->uuid . '" class="show-code form-check-input mr-0 ml-3 changeStatus" type="checkbox" name="is_active"' . $status . ' data-uuid="' . $membership->uuid . '" data-table="memberships" data-message="deactive"></div>';

                        $nestedData['action'] = '
                            <div class="dropdown">
                                <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> ...</a>
                                <div class="dropdown-menu w-40">
                                    <ul class="dropdown-content">
                                        <li><a class="flex items-center mr-3 dropdown-item" href="' . route('admin.settings.membership.edit', $membership->uuid) . '"><span class="icon text-white-50"><i class="fas fa-edit"></i></span>&nbsp;<span class="text">Edit</span></a></li>
                                        <li><a class="flex items-center text-danger deleteData mr-3 dropdown-item" href="javascript:;" data-table="memberships" data-uuid="' . $membership->uuid . '"><span class="icon text-white-50"><i class="fas fa-trash"></i></span>&nbsp;<span class="text">Delete</span></a></li>
                                    </ul>
                                </div>
                            </div>';
                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }

    public function setStatus(Request $request)
    {
        if ($request->ajax()) {
            $table = $request->find;
            switch ($table) {
                case 'categories':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->categoryService->updateStatus($request->only('is_active'), $id);
                    $message = 'Page status updated';
                    break;
                case 'pages':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->pageService->updatePage($request->only('is_active'), $id);
                    $message = 'Page status updated';
                    break;
                case 'memberships':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->subscriptionService->updateSubscription($request->only('is_active'), $id);
                    $message = 'Membership status updated';
                    break;
                case 'users':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->userService->update($request->only('is_active'), $id);
                    $message = 'User status updated';
                    break;
                case 'companies':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->companyService->updateCompany(['is_registered' => $request->is_active], $id);
                    $message = 'Company verification status updated';
                    break;
                case 'zones':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->zoneService->updateZone($request->only('is_active'), $id);
                    $message = 'Zone status updated';
                    break;
                default:
                    return $this->responseJson(false, 200, 'Something Wrong Happened');
            }

            if ($data) {
                return $this->responseJson(true, 200, $message);
            } else {
                return $this->responseJson(false, 500, 'Something Wrong Happened');
            }
        }
        abort(405);
    }

    public function setBrandingStatus(Request $request)
    {
        if ($request->ajax()) {
            $table = $request->find;
            $id = uuidtoid($request->uuid, $table);
            DB::beginTransaction();
            try {
                $data = $this->userService->update($request->only('is_branding'), $id);
                $message = 'User branding status updated';
                if ($data) {
                    $user= $this->userService->findById($id);
                    $notifyMessage = ($request->is_branding == 2) ? "Congratulations! Your Da'Ride branding request has been accepted" : "Sorry! Your Da'Ride branding request has been rejected";
                    $notiTitle = "Da'Ride Branding Request";
                    $notiMessage = ($request->is_branding == 2) ? "Da'Ride branding request has been accepted" : "Da'Ride branding request has been rejected";
                    $data = [
                        'type'=>'updateBrandingStatus',
                        //'sender_id'=> auth()->user()->id,
                        'title'=>$notiTitle,
                        'message'=>$notifyMessage
                    ];
                    $user->notify(new SiteNotification($user, $data));
                    $this->userService->addBrandingHistory([
                        "sender_id"=> $user->id,
                        'approver_id'=> auth()->user()->id,
                        "comment"=> $notiMessage,
                        "status"=> $request->is_branding,
                    ]);

                    if($user->fcm_token){
                        $user->notify(new SendPushNotification($notiTitle,$notiMessage,[$user->fcm_token]));
                    }

                    DB::commit();
                    return $this->responseJson(true, 200, $message);
                } else {
                    return $this->responseJson(false, 500, 'Something Wrong Happened');
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong.', 'error', true, true);
            }
        }
        abort(405);
    }

    public function deleteData(Request $request)
    {
        if ($request->ajax()) {
            $table = $request->find;
            switch ($table) {
                case 'categories':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->categoryService->deleteCategory($id);
                    $message = 'Banner Deleted';
                    break;
                case 'pages':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->pageService->deletePage($id);
                    $message = 'Page Deleted';
                    break;
                case 'fares':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->fareService->deleteFare($id);
                    $message = 'Fare Deleted';
                    break;
                case 'faqs':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->faqService->deleteFaq($id);
                    $message = 'FAQ Deleted';
                    break;
                case 'supports':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->supportService->deleteSupport($id);
                    $message = 'Support Deleted';
                    break;
                case 'users':
                    $data = $this->userService->deleteUser($request->except('find'));
                    $message = 'User Deleted';
                    break;
                case 'memberships':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->subscriptionService->deleteSubscription($id);
                    $message = 'Membership Plan Deleted';
                    break;
                case 'zones':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->zoneService->deleteZone($id);
                    $message = 'Zone Deleted';
                    break;
                case 'issues':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->medicalService->deleteIssue($id);
                    $message = 'Zone Deleted';
                    break;
                case 'questions':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->medicalService->deleteQuestion($id);
                    $message = 'Question Deleted';
                    break;
                case 'bookings':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->bookingService->delete($id);
                    $message = 'Booking Deleted';
                    break;
            }
            if (isset($data)) {
                return $this->responseJson(true, 200, $message);
            } else {
                return $this->responseJson(false, 500, 'Something Wrong Happened');
            }
        } else {
            abort(405);
        }
    }

    public function deleteTableData(Request $request)
    {
        if ($request->ajax()) {
            $table = $request->find;
            switch ($table) {
                case 'application_forms':
                    $id = uuidtoid($request->uuid, $table);
                    $data = ApplicationForm::find($id);
                    $data->delete();
                    $message = 'Application Form deleted';
                    break;
                case 'modules':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Module::find($id);
                    $data->delete();
                    $message = 'Module deleted';
                    break;
                case 'module_fields':
                    $id = uuidtoid($request->uuid, $table);
                    $data = ModuleField::find($id);
                    $data->delete();
                    $message = 'Module Field deleted';
                    break;
            }
            if (isset($data)) {
                return $this->responseJson(true, 200, $message);
            } else {
                return $this->responseJson(false, 500, 'Something Wrong Happened');
            }
        } else {
            abort(405);
        }
    }

    public function getCitiesByState(Request $request, $slug)
    {
        if ($request->ajax()) {
            $data = '';
            $id = slugtoid($slug, 'states');
            $state = $this->stateService->findState($id);
            $cities = $state->cities;
            if ($cities->isNotEmpty()) {
                $data .= '<option value="">Select A City</option>';
                foreach ($cities as $value) {
                    $data .= '<option value=' . $value->slug . '>' . $value->name . '</option>';
                }
                return $this->responseJson(true, 200, 'Cities data found', $data);
            }
            return $this->responseJson(false, 200, 'No Data Found', []);
        }
        abort(405);
    }

    public function getUsers(Request $request, $role = null)
    {
        if ($request->ajax()) {
            try {
                $filterCondition = [];
                if($request->is_registered){
                    $filterCondition['is_registered'] = $request->is_registered;
                }
                if($request->status){
                    switch($request->status){
                        case 'active': $status = 1; break;
                        case 'pending': $status = 0; break;
                        default: $status = $request->status; break;
                    }
                    if($status != 'all'){
                        $filterCondition['is_approve'] = $status;
                    }
                }else{
                    $status = 'all';
                }
                // dd($status);
                if(!$request->vtype){
                    $totalData = $this->userService->getTotalUsers($role, $status);
                }else{
                    $totalData = $this->userService->getTotalUsersByCategory($role, $request->vtype, $status);
                }
                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = 'id';
                $dir = 'desc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (empty($request->search) || $request->search['value'] == null) {
                    if(!$request->vtype){
                        $users = $this->userService->findUserByRole($filterCondition, $role, $order, $dir, $limit, $index, false);
                        // dd($users);
                    }else{
                        $users = $this->userService->findUserByRoleAndCategory($filterCondition, $role, $request->vtype, $order, $dir, $limit, $index, false);
                    }
                } else {
                    $search = $request->input('search.value');
                    if(!$request->vtype){
                        $users = $this->userService->findUserByRole($filterCondition, $role, $order, $dir, $limit, $index, false, $search);
                    }else{
                        $users = $this->userService->findUserByRoleAndCategory($filterCondition, $role, $request->vtype, $order, $dir, $limit, $index, false, $search);
                    }
                    if(!$request->vtype){
                        $totalFiltered = $this->userService->getTotalUsers($role, $status, $search);
                    }else{
                        $totalFiltered = $this->userService->getTotalUsersByCategory($role, $request->vtype, $status, $search);
                        // dd($totalFiltered);
                    }
                }

                if (!empty($users)) {
                    foreach ($users as $user) {
                        if ($role != 'driver') {
                            $status = $user->is_active == true ? 'checked' : '';
                            $statusType = '';
                        }else{
                            $status = $user->is_active == true ? '' : 'checked';
                            $statusType = 'suspend';
                        }
                        $brandingStatus = $user->is_branding == 2 ? 'checked' : '';
                        $index++;
                        $nestedData['sr'] = '<p>' . $index . '</p>';
                        $nestedData['id'] = $index;

                        $nestedData['name'] = '<div class="user"><div class="viewUser"><img class="user-avatar h-10 d-inline-block mr-3" src="' . $user->profile_picture . '" alt="' . $user->first_name . ' ' . $user->last_name . '"><label>' . $user->first_name . ' ' . $user->last_name;

                        if ($role == 'driver') {
                            $onlineStatus = ($user->is_online) ? '<span class="online-status online text-success">Online</span>' : '<span class="online-status offline text-slate-500">Offline</span>';
                            $nestedData['name'] .= ' ' . $onlineStatus;
                        }
                        $nestedData['name'] .= '</label></div></div>';

                        $nestedData['contact'] = '<div class="user">' . ($user->email ? '<p><a href="mailto:' . $user->email . '"><i class="fa fa-envelope mr-1" aria-hidden="true"></i>' . $user->email . '</a></p>' : '') . '<p class="numbertext"><i class="fa fa-mobile mr-1" aria-hidden="true"></i>' . $user->mobile_number . '</p></div>';

                        $nestedData['status'] = '<div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0"><input id="switch' . $user->uuid . '" class="show-code form-check-input mr-0 ml-3 changeStatus" type="checkbox" name="is_active"' . $status . ' data-uuid="' . $user->uuid . '" data-table="users" data-message="deactive" data-type="'.$statusType.'"></div>';

                        $nestedData['action'] = '<div class="flex">';

                        $nestedData['action'] .= '<div class="dropdown">
                            <a class="dropdown-toggle w-5 h-5 block ml-2" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> ...</a>
                            <div class="dropdown-menu w-40">
                                <ul class="dropdown-content">';



                        $editRoute = 'admin.users.edit';
                        switch ($role) {
                            case 'customer':
                                $editRoute = false;
                                break;
                            case 'council':
                                $editRoute = 'admin.users.council.edit';
                                break;
                            case 'agent':
                                $editRoute = 'admin.users.agent.edit';
                                break;
                            case 'driver':
                                $editRoute = 'admin.driver.edit';
                                break;
                        }
                        if ($editRoute) {
                            $nestedData['action'] .= '<li><a class="flex items-center mr-3 dropdown-item" href="' . route($editRoute, [$role, $user->uuid]) . '"><span class="icon text-white-50"><i class="fas fa-edit"></i></span>&nbsp;<span class="text">Edit</span></a></li>';
                        }
                        if ($role == 'customer') {
                            $nestedData['action'] .= '<li><a class="flex items-center dropdown-item" href="' . route('admin.customer.view', $user->uuid) . '"><span class="icon text-white-50"><i class="fas fa-eye"></i></span>&nbsp;<span class="text">View</span></a></li>';
                        }
                        $nestedData['action'] .= '<li><a class="flex items-center text-danger deleteData mr-3 dropdown-item" href="javascript:;" data-table="users" data-uuid="' . $user->uuid . '"><span class="icon text-white-50"><i class="fas fa-trash"></i></span>&nbsp;<span class="text">Delete</span></a></li>';

                        if ($role == 'admin') {
                            $nestedData['action'] .= '<li><a href="' . route('admin.users.attach.permission', [$role, $user->uuid]) . '" class="flex items-center dropdown-item"><span class="icon text-white-50"><i class="fas fa-paperclip "></i></span>&nbsp;<span class="text">Permissions</span></a></li>';
                        }

                        $nestedData['action'] .= '</ul>
                            </div>
                        </div>';

                        $nestedData['action'] .= '</div>';

                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }

    public function getUser(Request $request, $uuid)
    {
        if ($request->ajax()) {
            $id = uuidtoid($uuid, 'users');
            $filterConditions = [
                'id' => $id,
                // 'is_blocked' => false,
                'is_approve' => true,
            ];
            $user = $this->userService->findOne($filterConditions);
            return $this->responseJson(true, 200, 'Data Found', new UserResource($user));
        }
        abort(405);
    }

    public function getCompanies(Request $request)
    {
        if ($request->ajax()) {
            try {
                $totalData = $this->companyService->getTotalData();
                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = 'id';
                $dir = 'desc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (empty($request->input('search.value'))) {
                    $companies = $this->companyService->getListofCompanies($start, $limit, $order, $dir);
                } else {
                    $search = $request->input('search.value');
                    $companies = $this->companyService->getListofCompanies($start, $limit, $order, $dir, $search);
                    $totalFiltered = $this->companyService->getTotalData($search);
                }

                if (!empty($companies)) {
                    foreach ($companies as $company) {
                        $status = '';
                        if ($company->is_active) {
                            $status = 'checked';
                        }
                        $index++;
                        $nestedData['sr'] = '<p>' . $index . '</p>';
                        $nestedData['id'] = $index;
                        $nestedData['name'] = $company->name;
                        $nestedData['status'] = '<div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                        <input id="switch' . $company->uuid . '" class="show-code form-check-input mr-0 ml-3 changeStatus" type="checkbox" name="is_active"' . $status . ' data-uuid="' . $company->uuid . '" data-table="companies" data-message="deactive">
                        </div>';

                        $nestedData['action'] = '<div class="flex justify-center items-center"><a class="flex items-center mr-3" href="' . route('admin.vehicle.company.edit', $company->uuid) . '"><span class="icon text-white-50 mr-1"><i class="fas fa-edit"></i></span><span class="text">Edit</span></a><a class="flex items-center text-danger deleteData" href="javascript:;" data-table="companies" data-uuid="' . $company->uuid . '"><span class="icon text-white-50 mr-1"><i class="fas fa-trash"></i></span><span class="text">Delete</span></a></div>';
                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }

    public function pitchAction(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id = uuidtoid($request->uuid, 'pitches');
                $pitchUpdated = Pitch::where('id', $id)->update(['status' => $request->val]);
                if ($pitchUpdated) {
                    $status = true;
                    $code = 200;
                    $msg = "Successfully updated";
                    return $this->responseJson($status, $code, $msg, []);
                } else {
                    $status = false;
                    $code = 500;
                    $msg = "Something went wrong";
                    return $this->responseJson($status, $code, $msg, []);
                }
            } catch (\Throwable $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                $status = false;
                $code = 500;
                $msg = "Something went wrong";
                return $this->responseJson($status, $code, $msg, []);
            }
        }
        abort(405);
    }

    public function getVehicles(Request $request)
    {
        if ($request->ajax()) {
            try {
                $totalData = $this->vehicleService->getTotalData();
                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = 'id';
                $dir = 'desc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (empty($request->input('search.value'))) {
                    $vehicles = $this->vehicleService->getListofVehicles($start, $limit, $order, $dir);
                } else {
                    $search = $request->input('search.value');
                    $vehicles = $this->vehicleService->getListofVehicles($start, $limit, $order, $dir, $search);
                    $totalFiltered = $this->vehicleService->getTotalData($search);
                }
                if (!empty($vehicles)) {

                    foreach ($vehicles as $vehicle) {
                        $status = '';
                        if ($vehicle->is_active) {
                            $status = 'checked';
                        }
                        $index++;
                        $nestedData['sr'] = '<p>' . $index . '</p>';
                        $nestedData['id'] = $index;
                        $nestedData['info'] = $vehicle->name;
                        $nestedData['status'] = '<div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                        <input id="switch' . $vehicle->uuid . '" class="show-code form-check-input mr-0 ml-3 changeStatus" type="checkbox" name="is_active"' . $status . ' data-uuid="' . $vehicle->uuid . '" data-table="vehicles" data-message="deactive">
                        </div>';

                        $nestedData['action'] = '<div class="flex justify-center items-center"><a class="flex items-center mr-3" href="' . route('admin.vehicle.edit', $vehicle->uuid) . '"><span class="icon text-white-50 mr-1"><i class="fas fa-edit"></i></span><span class="text">Edit</span></a><a class="flex items-center text-danger deleteData" href="javascript:;" data-table="vehicles" data-uuid="' . $vehicle->uuid . '"><span class="icon text-white-50 mr-1"><i class="fas fa-trash"></i></span><span class="text">Delete</span></a></div>';
                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }
    public function getVehicleTypes(Request $request, $uuid = '')
    {
        if ($request->ajax()) {
            try {
                $filterConditions = [
                    'type' => 'vehicle'
                ];
                $parent_id = $uuid ? uuidtoid($uuid, 'categories') : null;
                $filterConditions['parent_id'] = $parent_id;
                $totalData = $this->categoryService->getTotalData($filterConditions);
                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = 'id';
                $dir = 'asc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (empty($request->input('search.value'))) {
                    //$vehicleTypes = $this->categoryService->listCategories($filterConditions);
                    $vehicleTypes = $this->categoryService->getListofCategories($filterConditions, $start, $limit, $order, $dir);
                } else {
                    $search = $request->input('search.value');
                    //$vehicleTypes = $this->categoryService->listCategories($filterConditions);
                    $vehicleTypes = $this->categoryService->getListofCategories($filterConditions, $start, $limit, $order, $dir, $search);
                    $totalFiltered = $this->categoryService->getTotalData($filterConditions, $search);
                }
                if (!empty($vehicleTypes)) {
                    foreach ($vehicleTypes as $vehicleType) {
                        $status = '';
                        if ($vehicleType->is_active) {
                            $status = 'checked';
                        }
                        $index++;
                        $nestedData['sr'] = '<p>' . $index . '</p>';
                        $nestedData['id'] = $index;
                        $nestedData['image'] = "<img src='".$vehicleType->display_image."' style='width:30px; height:30px;'>";
                        $nestedData['type'] = $vehicleType->name;

                        $nestedData['action'] = '<div class="flex justify-end">';
                        if(count($vehicleType->subCategory)>0){
                            $nestedData['action'] .= '<a class="flex items-center mr-3" href="' . route('admin.vehicle.type.list', $vehicleType->uuid) . '"><span class="icon text-white-50 mr-1"><i class="fa-regular fa-eye"></i></span><span class="text">Types</span></a>';
                            $nestedData['action'] .= '<a class="flex items-center mr-3" href="' . route('admin.vehicle.body.type.list', $vehicleType->uuid) . '"><span class="icon text-white-50 mr-1"><i class="fa-regular fa-eye"></i></span><span class="text">Body Types</span></a>';
                        }
                        $nestedData['action'] .= '<a class="flex items-center mr-3" href="' . route('admin.vehicle.type.edit', $vehicleType->uuid) . '"><span class="icon text-white-50 mr-1"><i class="fas fa-edit"></i></span><span class="text">Edit</span></a>';
                        $nestedData['action'] .= '</div>';

                        // $nestedData['status'] = '<div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                        // <input id="switch' . $vehicleType->uuid . '" class="show-code form-check-input mr-0 ml-3 changeStatus" type="checkbox" name="is_active"' . $status . ' data-uuid="' . $vehicleType->uuid . '" data-table="categories" data-message="deactive">
                        // </div>';

                        // $nestedData['action'] = '<div class="flex justify-center items-center"><a class="flex items-center mr-3" href="' . route('admin.vehicle.type.edit', $vehicleType->uuid) . '"><span class="icon text-white-50 mr-1"><i class="fas fa-edit"></i></span><span class="text">Edit</span></a><a class="flex items-center text-danger deleteData" href="javascript:;" data-table="categories" data-uuid="' . $vehicleType->uuid . '"><span class="icon text-white-50 mr-1"><i class="fas fa-trash"></i></span><span class="text">Delete</span></a></div>';
                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }
    public function getVehicleBodyTypes(Request $request, $uuid = '')
    {
        if ($request->ajax()) {
            try {
                $filterConditions = [
                    'type' => 'vehicle_body'
                ];
                $parent_id = $uuid ? uuidtoid($uuid, 'categories') : null;
                $filterConditions['parent_id'] = $parent_id;
                $totalData = $this->categoryService->getTotalData($filterConditions);
                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = 'id';
                $dir = 'asc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (empty($request->input('search.value'))) {
                    //$vehicleTypes = $this->categoryService->listCategories($filterConditions);
                    $vehicleTypes = $this->categoryService->getListofCategories($filterConditions, $start, $limit, $order, $dir);
                } else {
                    $search = $request->input('search.value');
                    //$vehicleTypes = $this->categoryService->listCategories($filterConditions);
                    $vehicleTypes = $this->categoryService->getListofCategories($filterConditions, $start, $limit, $order, $dir, $search);
                    $totalFiltered = $this->categoryService->getTotalData($filterConditions, $search);
                }

                if (!empty($vehicleTypes)) {
                    foreach ($vehicleTypes as $vehicleType) {
                        $index++;
                        $nestedData['sr'] = '<p>' . $index . '</p>';
                        $nestedData['id'] = $index;
                        $nestedData['image'] = "<img src='".$vehicleType->display_image."' style='width:30px; height:30px;'>";
                        $nestedData['type'] = $vehicleType->name;
                        $nestedData['action'] = '<div class="flex justify-end"><a class="flex items-center mr-3" href="' . route('admin.vehicle.body.type.edit', $vehicleType->uuid) . '"><span class="icon text-white-50 mr-1"><i class="fas fa-edit"></i></span><span class="text">Edit</span></a></div>';
                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }
    public function getFares(Request $request)
    {
        if ($request->ajax()) {
            try {
                $totalData = $this->fareService->getTotalData();
                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = 'id';
                $dir = 'desc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (empty($request->input('search.value'))) {
                    $fares = $this->fareService->getListofFare($start, $limit, $order, $dir);
                } else {
                    $search = $request->input('search.value');
                    $fares = $this->fareService->getListofFare($start, $limit, $order, $dir, $search);
                    $totalFiltered = $this->fareService->getTotalData($search);
                }

                if ($fares) {
                    foreach ($fares as $fare) {
                        $carbonStartTime = Carbon::createFromFormat('H:i', $fare->start_at);
                        $convertedStartTime = $carbonStartTime->format('h:i A');
                        $carbonEndTime = Carbon::createFromFormat('H:i', $fare->end_at);
                        $convertedEndTime = $carbonEndTime->format('h:i A');
                        $nestedData['category'] = $fare->category?->name;
                        $nestedData['hours_range'] = $convertedStartTime . ' - ' . $convertedEndTime;
                        $nestedData['amount'] = '&#8377; ' . $fare->amount . '/km';

                        $nestedData['action'] = "<div class='flex justify-center items-center'><a class='flex items-center mr-3 fare_edit_btn' href='javascript:void(0)' data-value='".json_encode($fare)."'><span class='icon text-white-50 mr-1'><i class='fas fa-edit'></i></span><span class='text'>Edit</span></a><a class='flex items-center text-danger deleteData' href='javascript:void(0)' data-table='fares' data-uuid='" . $fare->uuid . "'><span class='icon text-white-50 mr-1'><i class='fas fa-trash'></i></span><span class='text'>Delete</span></a></div>";
                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }

    public function getHelperFares(Request $request)
    {
        if ($request->ajax()) {
            try {
                $totalData = $this->fareService->getTotalData();
                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = 'id';
                $dir = 'desc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (empty($request->input('search.value'))) {
                    $fares = $this->helperFareService->getListofHelperFare($start, $limit, $order, $dir);
                } else {
                    $search = $request->input('search.value');
                    $fares = $this->helperFareService->getListofHelperFare($start, $limit, $order, $dir, $search);
                    $totalFiltered = $this->helperFareService->getTotalData($search);
                }

                if ($fares) {
                    foreach ($fares as $fare) {
                        $nestedData['amount'] = '&#8377; ' . $fare->amount . '/Helper';

                        $nestedData['action'] = "<div class='flex justify-end items-center'><a class='flex items-center mr-3 helper_fare_edit_btn' href='javascript:void(0)' data-value='".json_encode($fare)."'><span class='icon text-white-50 mr-1'><i class='fas fa-edit'></i></span><span class='text'>Edit</span></a></div>";
                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }
    public function getZones(Request $request)
    {
        if ($request->ajax()) {
            try {
                $totalData = $this->zoneService->getTotalData();
                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = 'id';
                $dir = 'desc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (empty($request->input('search.value'))) {
                    $zones = $this->zoneService->getListofZones($start, $limit, $order, $dir);
                } else {
                    $search = $request->input('search.value');
                    $zones = $this->zoneService->getListofZones($start, $limit, $order, $dir, $search);
                    $totalFiltered = $this->zoneService->getTotalData($search);
                }

                if ($zones) {
                    foreach ($zones as $zone) {
                        $status = '';
                        if ($zone->is_active) {
                            $status = 'checked';
                        }
                        $index++;
                        $nestedData['sr'] = '<p>' . $index . '</p>';
                        $nestedData['id'] = $index;
                        $nestedData['name'] = $zone->name;

                        $nestedData['status'] = '<div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                        <input id="switch' . $zone->uuid . '" class="show-code form-check-input mr-0 ml-3 changeStatus" type="checkbox" name="is_active"' . $status . ' data-uuid="' . $zone->uuid . '" data-table="zones" data-message="deactive">
                        </div>';

                        $nestedData['action'] = '<div class="flex justify-center items-center"><a class="flex items-center mr-3" href="' . route('admin.settings.zone.edit', $zone->uuid) . '"><span class="icon text-white-50"><i class="fas fa-edit"></i></span><span class="text">Edit</span></a><a class="flex items-center text-danger deleteData" href="javascript:;" data-table="zones" data-uuid="' . $zone->uuid . '"><span class="icon text-white-50"><i class="fas fa-trash"></i></span><span class="text">Delete</span></a></div>';

                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }
    public function getWalletTransactions(Request $request)
    {
        if ($request->ajax()) {
            try {
                $user_id = uuidtoid($request->user_uuid, 'users');
                $user= $this->userService->findById($user_id);
                $filterConditions = ['transactionable_id'=>$user->wallet->id];
                $totalData = $this->transactionService->getTotalData($filterConditions);
                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = 'id';
                $dir = 'desc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (empty($request->input('search.value'))) {
                    $transactions = $this->transactionService->getListofTransactions($filterConditions, $start, $limit, $order, $dir);
                } else {
                    $search = $request->input('search.value');
                    $transactions = $this->transactionService->getListofTransactions($filterConditions, $start, $limit, $order, $dir, $search);
                    $totalFiltered = $this->transactionService->getTotalData($filterConditions, $search);
                }

                if ($transactions) {
                    foreach ($transactions as $transaction) {
                        $index++;
                        $nestedData['sr'] = '<p>' . $index . '</p>';
                        $nestedData['txnId'] = '<div class="txn-no">
                            Transaction ID
                            # ' . $transaction->transaction_no .
                            '<div class="txn-date"><span class="icon text-white-50"><i class="fas fa-calendar"></i> </span> '.$transaction->created_at->format('jS M Y') .
                        '</div></div>';
                        $nestedData['amount'] = '<div class="txn-amount">
                            <span class="icon text-white-50"><i class="fas fa-credit-card"></i> Transaction Amount </span>' . $transaction->currency . ' ' . $transaction->amount .
                        '</div>
                        <div class="amount">'
                            . $transaction->currency . ' ' . $transaction->amount * getSiteSetting('site_commission_percentage')
                            . (($transaction->type == 'credit') ? ' Credited to ' : ' Dabit from ') . '<span class="icon text-white-50"><i class="fas fa-wallet"></i></span>
                        </div>';
                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }
    public function updateMediaStatus(Request $request)
    {
        if ($request->ajax()) {
            // $table = 'media';
            $user_id = uuidtoid($request->user_uuid, 'users');
            $user= $this->userService->findById($user_id);
            $media_type = $request->media_type;
            $is_approve = $request->is_approve;
            $media_name = '';
            if($media_type == 'image'){
                $media_name = 'Profile picture';
            }else if($media_type == 'vehicle_image'){
                $media_name = 'Vehicle image';
            }else{
                $media_name = ucfirst($media_type);
            }
            $message = $is_approve ? $media_name.' approved' : $media_name.' unapproved';
            DB::beginTransaction();
            try {

                if($media_type == 'image' || $media_type == 'vehicle_image'){
                    $data = $user->media()
                    ->where(function($q) use($media_type){
                        $q->where('media_type',$media_type);
                    })->update(['is_approve' => $is_approve]);
                }else{
                    $data = $user->media()
                    ->where(function($q) use($media_type){
                        $q->where('media_type',$media_type.'_front')
                        ->orWhere('media_type', $media_type.'_back');
                    })->update(['is_approve' => $is_approve]);
                }

                if ($data) {
                    $approvedMediaCount = $user->media()
                        ->where(function($q) {
                            $q->where('media_type', 'aadhar_front')->orWhere('media_type', 'aadhar_back')->orWhere('media_type', 'licence_front')->orWhere('media_type', 'licence_back')->orWhere('media_type', 'rc_front')->orWhere('media_type', 'rc_back')->orWhere('media_type', 'image')->orWhere('media_type', 'vehicle_image');
                        })->where('is_approve', 1)
                    ->count();
                    if($approvedMediaCount == 8){
                        $user->update(['is_approve' => 1]);
                        $text = getSiteSetting('account_verified_template') ? getSiteSetting('account_verified_template') : "Thank You For Choosing Da%27Ride, your Da%27Ride Driver Account Is Verified";
                        sendSms($user->mobile_number, $text);
                    }
                    DB::commit();
                    return $this->responseJson(true, 200, $message);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $this->responseJson(false, 500, 'Something Wrong Happened');
            }
        }
        abort(405);
    }
    public function updateToken(Request $request){
        DB::beginTransaction();
        try{
            //dd($request->token);
            $isUserUpdated = auth()->user()->update(['fcm_token'=>$request->token]);
            if($isUserUpdated){
                DB::commit();
                return $this->responseJson(true, 200, [
                    'success'=>true
                ]);
            }
        }catch(\Exception $e){
            DB::rollBack();
            return $this->responseJson(false, 500, [
                'success'=>false
            ]);
        }
    }

    public function getUsersByConditions(Request $request, $role = null)
    {
        if ($request->ajax()) {
            $role = $request->role;
            try {
                $filterCondition = [];
                if($request->is_registered != ''){
                    $filterCondition['is_registered'] = $request->is_registered;
                }
                if($request->is_approve){
                    $filterCondition['is_approve'] = $request->is_approve;
                }
                $status = 'all';
                $maxLimit = $request->limit ? $request->limit : '';
                $totalData = $this->userService->getTotalUsersByCondition($role, $filterCondition, $status, $maxLimit);

                $totalFiltered = $totalData;
                $limit = !$maxLimit ? $request->input('length') : $maxLimit;
                $start = $request->input('start');
                $order = 'id';
                $dir = 'desc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (empty($request->search)) {
                    $users = $this->userService->findUserByRole($filterCondition, $role, $order, $dir, $limit, $index, false);
                } else {
                    $search = $request->input('search.value');
                    $users = $this->userService->findUserByRole($filterCondition, $role, $order, $dir, $limit, $index, false, $search);
                    $totalFiltered = $this->userService->getTotalUsersByCondition($role, $filterCondition, $status, $maxLimit, $search);
                }

                if (!empty($users)) {
                    foreach ($users as $user) {

                        $index++;
                        $nestedData['sr'] = '<p>' . $index . '</p>';
                        $nestedData['id'] = $index;

                        $onlineStatus = '';
                        if($role == 'driver' && $request->is_registered){
                            $onlineStatus = ($user->is_online) ? '<span class="online-status online text-success">Online</span>' : '<span class="online-status offline text-slate-500">Offline</span>';
                        }

                        $nestedData['name'] = '<div class="user"><div class="viewUser"><img class="user-avatar" src="' . $user->profile_picture . '" alt="' . $user->first_name . ' ' . $user->last_name . '"><label>' . $user->first_name . ' ' . $user->last_name. ' ' . $onlineStatus . '</label></div></div>';

                        $nestedData['contact'] = '<div class="user">' . ($user->email ? '<p><a href="mailto:' . $user->email . '"><i class="fa fa-envelope mr-1" aria-hidden="true"></i>' . $user->email . '</a></p>' : '') . '<p class="numbertext"><i class="fa fa-mobile mr-1" aria-hidden="true"></i>' . $user->mobile_number . '</p></div>';

                        $nestedData['vehicleType'] = $user?->vehicle?->vehicleType?->name;
                        if($user?->vehicle?->vehicleType?->slug == 'truck'){
                            $nestedData['vehicleType'] .= '<br>' . $user?->vehicle?->vehicleSubType?->name .' ( '.$user?->vehicle?->vehicleBodyType?->name.' )';
                        }

                        $nestedData['vehicleNumber'] = $user?->vehicle?->registration_number;
                        $nestedData['registrationDate'] = $user->created_at->format('d/m/Y') .'<br>'.$user->created_at->format('h:i A');

                        /*$userDocuments = [];
                        $userDocCaptions = [];
                        if($user->vehicle?->vehicleDocument('aadhar_front')){
                            $userDocuments[] = $user->vehicle?->vehicleDocument('aadhar_front');
                            $userDocCaptions[] = 'Aadhar Front';
                        }
                        if($user->vehicle?->vehicleDocument('aadhar_back')){
                            $userDocuments[] = $user->vehicle?->vehicleDocument('aadhar_back');
                            $userDocCaptions[] = 'Aadhar Back';
                        }
                        if($user->vehicle?->vehicleDocument('licence_front')){
                            $userDocuments[] = $user->vehicle?->vehicleDocument('licence_front');
                            $userDocCaptions[] = 'Licence Front';
                        }
                        if($user->vehicle?->vehicleDocument('licence_back')){
                            $userDocuments[] = $user->vehicle?->vehicleDocument('licence_back');
                            $userDocCaptions[] = 'Licence Back';
                        }
                        if($user->vehicle?->vehicleDocument('rc_front')){
                            $userDocuments[] = $user->vehicle?->vehicleDocument('rc_front');
                            $userDocCaptions[] = 'RC Front';
                        }
                        if($user->vehicle?->vehicleDocument('rc_back')){
                            $userDocuments[] = $user->vehicle?->vehicleDocument('rc_back');
                            $userDocCaptions[] = 'RC Back';
                        }*/


                        $nestedData['action'] = '<div class="flex mr-5">';

                        // $nestedData['action'] .= '<a class="flex items-center mr-2 viewDocs" target="_blank" href="#" data-docs="'.json_encode($userDocuments).'" data-captions="'.json_encode($userDocCaptions).'"><span class="icon text-white-50"><i class="fas fa-eye"></i></span>&nbsp;<span class="text"> Documents</span></a><a class="flex items-center dropdown-item" target="_blank" href="' . route('admin.driver.view', $user->uuid) . '"><span class="icon text-white-50"><i class="fas fa-eye"></i></span>&nbsp;<span class="text"> View</span></a>';

                        $linkTarget = (!$user->is_approve && $user->is_registered) ? '_blank' : '_self';
                        $nestedData['action'] .= '<a class="flex items-center dropdown-item" target="'.$linkTarget.'" href="' . route('admin.driver.view', $user->uuid) . '"><span class="icon text-white-50"><i class="fas fa-eye"></i></span>&nbsp;<span class="text"> View</span></a>';

                        $nestedData['action'] .= '</div>';

                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }
    public function getDeletedUsersByConditions(Request $request, $role = null)
    {
        if ($request->ajax()) {
            $role = $request->role;
            try {
                $filterCondition = [];
                if($request->is_registered){
                    $filterCondition['is_registered'] = $request->is_registered;
                }
                if($request->is_approve){
                    $filterCondition['is_approve'] = $request->is_approve;
                }
                $status = 'all';
                $maxLimit = $request->limit ? $request->limit : '';
                $totalData = $this->userService->getTotalDeletedUsersByCondition($role, $filterCondition, $status, $maxLimit);

                $totalFiltered = $totalData;
                $limit = !$maxLimit ? $request->input('length') : $maxLimit;
                $start = $request->input('start');
                $order = 'id';
                $dir = 'desc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (empty($request->search)) {
                    $users = $this->userService->findDeletedUserByRole($filterCondition, $role, $order, $dir, $limit, $index, false);
                } else {
                    $search = $request->input('search.value');
                    $users = $this->userService->findDeletedUserByRole($filterCondition, $role, $order, $dir, $limit, $index, false, $search);
                    $totalFiltered = $this->userService->getTotalDeletedUsersByCondition($role, $filterCondition, $status, $maxLimit, $search);
                }

                if (!empty($users)) {
                    foreach ($users as $user) {

                        $index++;
                        $nestedData['sr'] = '<p>' . $index . '</p>';
                        $nestedData['id'] = $index;

                        $nestedData['name'] = '<div class="user"><div class="viewUser"><img class="user-avatar" src="' . $user->profile_picture . '" alt="' . $user->first_name . ' ' . $user->last_name . '"><label>' . $user->first_name . ' ' . $user->last_name. '</label></div></div>';

                        $userEmailArr = explode('-', $user->email);
                        array_pop($userEmailArr);
                        $userEmail = implode('', $userEmailArr);
                        $nestedData['contact'] = '<div class="user">' . ($userEmail ? '<p><a href="mailto:' . $userEmail . '"><i class="fa fa-envelope mr-1" aria-hidden="true"></i>' . $userEmail . '</a></p>' : '') . '<p class="numbertext"><i class="fa fa-mobile mr-1" aria-hidden="true"></i>' . $user->mobile_number . '</p></div>';

                        $nestedData['vehicleType'] = $user?->vehicle?->vehicleType?->name;
                        if($user?->vehicle?->vehicleType?->slug == 'truck'){
                            $nestedData['vehicleType'] .= '<br>' . $user?->vehicle?->vehicleSubType?->name .' ( '.$user?->vehicle?->vehicleBodyType?->name.' )';
                        }

                        $nestedData['vehicleNumber'] = $user?->vehicle?->registration_number;
                        $nestedData['registrationDate'] = $user->created_at->format('d/m/Y') .'<br>'.$user->created_at->format('h:i A');
                        $nestedData['deletionDate'] = $user->deleted_at->format('d/m/Y') .'<br>'.$user->deleted_at->format('h:i A');

                        $nestedData['action'] = '<div class="flex mr-5">';


                        $nestedData['action'] .= '<a class="flex items-center dropdown-item" href="' . route('admin.driver.view.deleted', $user->uuid) . '"><span class="icon text-white-50"><i class="fas fa-eye"></i></span>&nbsp;<span class="text"> View</span></a>';

                        $nestedData['action'] .= '</div>';

                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }
    public function getBookings(Request $request, $status = null)
    {
        if ($request->ajax()) {
            try {
                $filterCondition = [];
                switch($status){
                    case 'booked': $filterCondition['status'] = 0; break;
                    case 'accepted': $filterCondition['status'] = 1; break;
                    case 'cancelled': $filterCondition['status'] = 2; break;
                    case 'rejected': $filterCondition['status'] = 3; break;
                }
                if($request->daterange){
                    $daterange = explode(' - ', $request->daterange);
                    $fromDate = trim($daterange[0]);
                    $toDate = trim($daterange[1]);
                    $filterCondition['fromDate'] = $fromDate ? date('Y-m-d H:i:s', strtotime($fromDate)) : null;
                    $filterCondition['toDate'] = $toDate ? date('Y-m-d H:i:s', strtotime($toDate)) : null;
                }
                $totalData = $this->bookingService->getTotalData($filterCondition);

                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = 'id';
                $dir = 'desc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (empty($request->search)) {
                    $bookings = $this->bookingService->listBookings($filterCondition, $order, $dir, $limit, $index, false);
                } else {
                    $search = $request->input('search.value');
                    $bookings = $this->bookingService->listBookings($filterCondition, $order, $dir, $limit, $index, false, $search);
                    $totalFiltered = $this->bookingService->getTotalData($filterCondition, $search);
                }

                if ($bookings) {
                    foreach ($bookings as $booking) {
                        $index++;
                        $nestedData['id'] = $index;
                        //dd($booking->patient->profile_picture);

                        $nestedData['patient'] = '<div class="user"><div class="viewUser"><img class="user-avatar" src="' . $booking->patient->profile_picture . '" alt="' . $booking->patient->full_name . '"><label>' . $booking->patient->full_name . '</label></div></div>';
                        $doctorDetails = '';
                        if($booking->doctor){
                            $doctorDetails = '<div class="user"><div class="viewUser"><img class="user-avatar" src="' . $booking->doctor->profile_picture . '" alt="' . $booking->doctor->full_name . '"><label>' . $booking->doctor->full_name . '</label></div></div>';
                        }
                        $nestedData['doctor'] = $doctorDetails;

                        $nestedData['issue'] = $booking->issue->name;

                        switch($booking->status){
                            case 1: $bookingStatus = '<span class="text-warning">Booked</span>'; break;
                            case 2: $bookingStatus = '<span class="text-danger">Cancelled</span>'; break;
                            case 3: $bookingStatus = '<span class="text-success">Attended</span>'; break;
                            case 4: $bookingStatus = '<span class="text-danger">Absent</span>'; break;
                        }

                        $nestedData['bookingDate'] = $booking->booking_datetime ? Carbon::parse($booking->booking_datetime)->format('D d M, h:i A') : '';
                        $nestedData['status'] = $bookingStatus;
                        $nestedData['amount'] = $booking->price ? '$ ' . $booking->price : '';
                        $nestedData['action'] = '<div class="flex mr-5">';

                        $nestedData['action'] = '<div class="flex"><a class="flex items-center mr-3" href="' . route('admin.booking.edit', $booking->uuid) . '"><span class="icon text-white-50"><i class="fas fa-edit"></i></span><span class="text">Edit</span></a><a class="flex items-center text-danger deleteData" href="javascript:;" data-table="bookings" data-uuid="' . $booking->uuid . '"><span class="icon text-white-50"><i class="fas fa-trash"></i></span><span class="text">Delete</span></a></div>';

                        $data[] = $nestedData;
                        $nestedData = [];

                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }
    public function getReferrals(Request $request, $role = null)
    {
        if ($request->ajax()) {
            try {
                $filterCondition = [];
                $totalData = $this->userService->getTotalReferrals($filterCondition);
                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = 'id';
                $dir = 'desc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (empty($request->search) || $request->search['value'] == null) {
                    $referrals = $this->userService->findReferrals($filterCondition, $order, $dir, $limit, $index, false);
                } else {
                    $search = $request->input('search.value');
                    $referrals = $this->userService->findReferrals($filterCondition, $order, $dir, $limit, $index, false, $search);
                    $totalData = $this->userService->getTotalReferrals($filterCondition, $search);
                }

                if (!empty($referrals)) {
                    foreach ($referrals as $referral) {
                        $index++;
                        $nestedData['sr'] = '<p>' . $index . '</p>';
                        $nestedData['id'] = $index;

                        $nestedData['name'] = '<div class="user"><div class="viewUser"><label>' . $referral->name . '</label></div></div>';

                        $nestedData['mobile_number'] = $referral->mobile_number ? '<div class="user"><p class="numbertext"><i class="fa fa-mobile mr-1" aria-hidden="true"></i>' . $referral->mobile_number . '</p></div>' : '';

                        $nestedData['ibd_number'] = '<div class="user"><p class="numbertext">' .  $referral->ibd_number . '</p></div>';

                        $nestedData['referred_user'] = '<div class="user"><p>' . $referral->referredUser->full_name . '</p></div>';

                        $nestedData['reference_type'] = '<div class="user"><p>' .  ucfirst($referral->type) . '</p></div>';

                        $nestedData['reference_platform'] = '<div class="user"><p>' .  $referral->referencePlatform->name . '</p></div>';

                        $nestedData['action'] = '<div class="flex"><a class="flex items-center mr-3" href="' . route('admin.referral.user.edit', $referral->uuid) . '"><span class="icon text-white-50"><i class="fas fa-edit"></i></span><span class="text">Edit</span></a><a class="flex items-center text-danger deleteData" href="javascript:;" data-table="referrals" data-uuid="' . $referral->uuid . '"><span class="icon text-white-50"><i class="fas fa-trash"></i></span><span class="text">Delete</span></a></div>';

                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }
    public function getIssues(Request $request)
    {
        if ($request->ajax()) {
            try {
                $filterCondition = [];
                $totalData = $this->medicalService->getTotalIssues($filterCondition);
                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = 'id';
                $dir = 'desc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (!$request->search || $request->search['value'] == null) {
                    $issues = $this->medicalService->listIssues($filterCondition, $order, $dir, $limit, $index);
                } else {
                    $search = $request->input('search.value');
                    $issues = $this->medicalService->listIssues($filterCondition, $order, $dir, $limit, $index, false, $search);
                    $totalData = $this->medicalService->getTotalIssues($filterCondition, $search);
                }
                if ($issues) {
                    foreach ($issues as $issue) {
                        $index++;
                        $nestedData['sr'] = '<p>' . $index . '</p>';
                        $nestedData['id'] = $index;

                        $nestedData['name'] = '<div class="user"><div class="viewUser"><label>' . $issue->name . '</label></div></div>';

                        $nestedData['type'] = '<div class="user"><p>' . $issue->type . '</p></div>';

                        $nestedData['action'] = '<div class="flex"><a class="flex items-center mr-3" href="' . route('admin.medical.issue.edit', $issue->uuid) . '"><span class="icon text-white-50"><i class="fas fa-edit"></i></span><span class="text">Edit</span></a><a class="flex items-center text-danger deleteData" href="javascript:;" data-table="issues" data-uuid="' . $issue->uuid . '"><span class="icon text-white-50"><i class="fas fa-trash"></i></span><span class="text">Delete</span></a></div>';

                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }
    public function getQuestions(Request $request)
    {
        if ($request->ajax()) {
            try {
                $filterCondition = [];
                $totalData = $this->medicalService->getTotalQuestions($filterCondition);
                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = 'id';
                $dir = 'desc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (!$request->search || $request->search['value'] == null) {
                    $questions = $this->medicalService->listQuestions($filterCondition, $order, $dir, $limit, $index);
                } else {
                    $search = $request->input('search.value');
                    $questions = $this->medicalService->listQuestions($filterCondition, $order, $dir, $limit, $index, false, $search);
                    $totalData = $this->medicalService->getTotalQuestions($filterCondition, $search);
                }
                if ($questions) {
                    foreach ($questions as $question) {
                        $index++;
                        $nestedData['sr'] = '<p>' . $index . '</p>';
                        $nestedData['id'] = $index;

                        $nestedData['name'] = '<div class="user"><div class="viewUser"><label>' . $question->name . '</label></div></div>';

                        $nestedData['issues'] = '<div class="user"><p>' . $question->issue_lists . '</p></div>';

                        $nestedData['type'] = '<div class="user"><p>' . $question->type . '</p></div>';

                        $nestedData['action'] = '<div class="flex"><a class="flex items-center mr-3" href="' . route('admin.medical.question.edit', $question->uuid) . '"><span class="icon text-white-50"><i class="fas fa-edit"></i></span><span class="text">Edit</span></a><a class="flex items-center text-danger deleteData" href="javascript:;" data-table="questions" data-uuid="' . $question->uuid . '"><span class="icon text-white-50"><i class="fas fa-trash"></i></span><span class="text">Delete</span></a></div>';

                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }
    public function getDoctorAvailabilities(Request $request)
    {
        if ($request->ajax()) {
            try {
                $role = 'doctor';
                $filterCondition = [];
                $status = 'all';
                if(!$request->vtype){
                    $totalData = $this->userService->getTotalUsers($role, $status);
                }else{
                    $totalData = $this->userService->getTotalUsersByCategory($role, $request->vtype, $status);
                }
                $totalFiltered = $totalData;
                $limit = $request->input('length');
                $start = $request->input('start');
                $order = 'id';
                $dir = 'desc';
                $index = $start;
                $nestedData = [];
                $data = [];
                if (empty($request->search) || $request->search['value'] == null) {
                    $users = $this->userService->findUserByRole($filterCondition, $role, $order, $dir, $limit, $index, false);
                } else {
                    $search = $request->input('search.value');
                    $users = $this->userService->findUserByRole($filterCondition, $role, $order, $dir, $limit, $index, false, $search);
                    $totalFiltered = $this->userService->getTotalUsers($role, $status, $search);
                }

                if (!empty($users)) {
                    foreach ($users as $user) {
                        $index++;
                        $nestedData['sr'] = '<p>' . $index . '</p>';
                        $nestedData['id'] = $index;

                        $nestedData['name'] = '<div class="user"><div class="viewUser"><img class="user-avatar h-10 d-inline-block mr-3" src="' . $user->profile_picture . '" alt="' . $user->first_name . ' ' . $user->last_name . '"><label>' . $user->first_name . ' ' . $user->last_name . '</label></div></div>';

                        // $nestedData['contact'] = '<div class="user">' . ($user->email ? '<p><a href="mailto:' . $user->email . '"><i class="fa fa-envelope mr-1" aria-hidden="true"></i>' . $user->email . '</a></p>' : '') . '<p class="numbertext"><i class="fa fa-mobile mr-1" aria-hidden="true"></i>' . $user->mobile_number . '</p></div>';

                        // dd($user->todays_availabilities);
                        $availabilities = '';
                        $count = 0;
                        if($user->todays_availabilities){
                            foreach($user->todays_availabilities as $todays_availability){
                                if($count){
                                    $availabilities .= '<br>';
                                }
                                if($todays_availability->available_from){
                                    $availabilities .= Carbon::parse($todays_availability->available_from)->format('h:i A') . ' - ' . Carbon::parse($todays_availability->available_to)->format('h:i A');
                                    $count++;
                                }
                            }
                        }
                        $nestedData['availability'] = $availabilities;

                        $nestedData['action'] = '<div class="flex"><a class="flex items-center mr-3" href="' . route('admin.booking.doctor.availability.alter', $user->uuid) . '"><span class="icon text-white-50 mr-1"><i class="fas fa-edit"></i></span><span class="text">Edit</span></a></div>';

                        $data[] = $nestedData;
                        $nestedData = [];
                    }
                }
                $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) $totalData,
                    "recordsFiltered" => (int) $totalFiltered,
                    "data" => $data,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "draw" => (int) $request->input('draw'),
                    "recordsTotal" => (int) 0,
                    "recordsFiltered" => (int) 0,
                    "data" => []
                );
            }
        }
        abort(405);
    }
    public function getAvailableSlots(Request $request)
    {
        if ($request->ajax()) {
            // $request->validate(
            //     [
            //         'doctor_id' => 'required',
            //         'selected_date' => 'required',
            //     ],
            //     [
            //         'doctor_id' => 'Please select a doctor',
            //         'selected_date' => 'Please select date',
            //     ]
            // );
            try {
                $doctorId = $request->doctor_id;
                $selectedDate   = $request->selected_date;
                $selectedSlot   = $request->selected_slot;
                $selectedDay    = Carbon::parse($selectedDate)->format('l');
                $startPeriod    = Carbon::parse($selectedDate.' 8:00:00');
                $endPeriod      = Carbon::parse($selectedDate.' 18:00:00');
                $period         = CarbonPeriod::create($startPeriod, '15 minutes', $endPeriod);
                if(!$doctorId){
                    // dd($this->bookingService->getAllBookedTimesByDate($selectedDate));
                    // $bookedTimes = $this->bookingService->getAllBookedTimesByDate($selectedDate);
                    $bookedTimes = $this->bookingService->getAllUnavailableTimesByDate($selectedDate);
                }else{
                    $doctor = $this->userService->findById($doctorId);
                    $bookedTimes = $doctor->bookedTimesByDate($selectedDate);
                }

                $timeBox = '';
                foreach ($period as $k => $time){
                    if(!$doctorId){
                        $disabled = (in_array($time, $bookedTimes) && $selectedSlot != $time) ? 'disabled' : '';
                    }else{
                        $availabilities = $doctor->availabilitiesByDay($selectedDay, $time);
                        $disabled = ((!$availabilities->count() || in_array($time, $bookedTimes))  && $selectedSlot != $time) ? 'disabled' : '';
                    }
                    $checked = ($selectedSlot && $selectedSlot == $time) ? 'checked' : '';
                    $timeBox .= '<div class="time_box">
                        <input id="time'.$k.'" type="radio" name="booking_datetime" value="'.$time.'" class="booking_datetime" '.$disabled.' '.$checked.'>
                        <label for="time'.$k.'">
                            '.$time->format('h:i A').'
                        </label>
                    </div>';
                }
                $jsonData = array(
                    "status" => true,
                    "data" => $timeBox,
                );

                return response()->json($jsonData);
            } catch (\Exception $e) {
                logger($e->getMessage() . ' on ' . $e->getFile() . ' line number ' . $e->getLine());
                return $jsonData = array(
                    "status" => false,
                    "data" => []
                );
            }
        }
        abort(405);
    }
}


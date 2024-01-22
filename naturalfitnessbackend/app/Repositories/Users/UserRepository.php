<?php

namespace App\Repositories\Users;

use Carbon;
use App\Models\User\Role;
use App\Models\User\User;
use App\Models\User\Address;
use App\Mail\SendMailable;
use App\Traits\UploadAble;
use Illuminate\Support\Str;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Mail;
use App\Contracts\Users\UserContract;
use App\Models\Site\Media;
use App\Models\Site\BrandingHistory;
use App\Models\Site\Referral;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class UserRepository
 *
 * @package \App\Repositories
 */
class UserRepository extends BaseRepository implements UserContract
{
    use UploadAble;

    protected $model;
    protected $documentModel;
    protected $roleModel;
    protected $addressModel;
    protected $productModel;
    protected $brandingHistoryModel;
    protected $referralModel;
    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(
        User $model,
        Role $roleModel,
        BrandingHistory $brandingHistoryModel,
        Address $addressModel,
        Referral $referralModel
    ) {
        parent::__construct($model);
        $this->model = $model;
        $this->roleModel = $roleModel;
        $this->brandingHistoryModel = $brandingHistoryModel;
        $this->addressModel = $addressModel;
        $this->referralModel = $referralModel;
    }


    public function findUsers(
        $profileType,
        $filterConditions = null,
        $orderBy = 'id',
        $sortBy = 'desc',
        $limit = null,
        $inRandomOrder = false
    ) {
        $query = $this->model
            ->where('profile_type', $profileType)
            ->with('profile');
        if (!is_null($filterConditions)) {
            $query = $query->where($filterConditions);
        }

        // if($profileType == 'performer'){
        //     $query = $query->where(function($query)  {
        //         $query->where('membership_plan','>', 0)
        //               ->where('package_status', true);
        //     });
        // }

        /*if(!is_null($filterConditions)){
            foreach($filterConditions as $fKey => $fCondition){
                if($fKey == 'keyword'){
                    $query = $query->where(function($query) use ($fCondition) {
                                    $query->where('firstname', 'LIKE', "%$fCondition%")
                                    ->orWhere('username', 'LIKE', "%$fCondition%")
                                    ->orWhere('phone_number', 'LIKE', "%$fCondition%")
                                    ->orWhere('email', 'LIKE', "%$fCondition%");
                                });
                }elseif($fKey == 'ageRange'){
                    $query = $query->whereHas('profile', function(Builder $query) use($fCondition){
                        $query->whereBetween('birthday', [$fCondition['endingDob'], $fCondition['startingDob']]);
                    });
                }
                elseif(in_array($fKey, array('gender', 'measurements', 'icaterto', 'ethnicity', 'servicetype', 'paymentmethod', 'bodytype', 'country', 'state', 'city', 'nationality'))){
                    $query = $query->whereHas('profile', function(Builder $query) use($fKey, $fCondition){
                        $query->where($fKey, $fCondition);
                    });
                }elseif($fKey == 'height'){
                    if(isset($fCondition['minimum']) && isset($fCondition['maximum']) && $fCondition['minimum'] && $fCondition['maximum']){
                        $query = $query->whereHas('profile', function(Builder $query) use($fCondition){
                            $query->whereBetween('height',[$fCondition['minimum'], $fCondition['maximum']]);
                        });
                    }
                }
                elseif(in_array($fKey, array('servicesoffered', 'idonotoffer'))){
                    $query = $query->whereHas('profile', function(Builder $query) use($fKey, $fCondition){
                        if(!in_array('All', $fCondition)){
                            $query->whereJsonContains($fKey, $fCondition);
                        }
                    });
                }elseif($fKey == 'costRange'){

                }else{
                    $query = $query->where($fKey, $fCondition);
                }

                if(in_array($fKey, array('country', 'state', 'city'))){
                    $query = $query->orWhereHas('userlocations', function($query) use($fKey, $fCondition) {
                        $query->where($fKey, $fCondition);
                    });
                }
            }
        }*/

        if ($inRandomOrder) {
            $query = $query->inRandomOrder();
        } else {
            //$query = $query->orderBy('autoboost_time', 'desc');
            //$query = $query->orderBy('membership_plan', 'desc');
            $query = $query->orderBy($orderBy, $sortBy);
        }
        if (!is_null($limit)) {
            return $query->paginate($limit);
        }

        return $query->get();
    }

    public function userSearch(
        $profileType,
        $filterConditions = null,
        $orderBy = 'id',
        $sortBy = 'desc',
        $limit = null,
        $inRandomOrder = false
    ) {
        $query = $this->model
            ->where('profile_type', $profileType)
            ->with('profile');

        if ($profileType == 'performer') {
            $query = $query->where(function ($query) {
                $query->where('membership_plan', '>', 0)
                    ->where('is_hidden', 0)
                    ->where('package_status', true);
            });
        }
        if (!is_null($filterConditions)) {
            foreach ($filterConditions as $fKey => $fCondition) {
                if (in_array($fKey, array('servicesoffered', 'idonotoffer', 'category'))) {
                    $query = $query->whereHas('profile', function (Builder $query) use ($fKey, $fCondition) {
                        if (!in_array('All', $fCondition)) {
                            $query->whereJsonContains($fKey, $fCondition);
                        }
                    });
                } elseif (in_array($fKey, array('gender', 'measurements', 'icaterto', 'ethnicity', 'servicetype', 'paymentmethod', 'bodytype', 'country', 'state', 'city', 'nationality'))) {
                    $query = $query->whereHas('profile', function (Builder $query) use ($fKey, $fCondition) {
                        $query->where($fKey, $fCondition);
                    });
                }
            }
        }

        if ($inRandomOrder) {
            $query = $query->inRandomOrder();
        }
        $models = $query->get();
        // dump($models->pluck('id')->toArray());

        // foreach($models as $model){
        //     dump($model->id .' -- '.$model->boost_sort_date_time .' -- '.$model->autoboost_time .' -- '. $model->created_at . ' ##'.($model->autoboost_time ? 'autoboost_time' : 'created_at'));
        // }

        $models = $models->sortByDesc('boost_sort_date_time');

        // dd($models->pluck('id')->toArray());

        if (is_null($limit)) {
            return $models;
        } else {
            return $models->paginate($limit);
        }
    }



    /**
     * Fetch list of users by user ids
     *
     * @param array $userIds
     * @param array $userIds
     * @return mixed
     */
    public function findUserByIds(array $userIds, array $select)
    {
        try {
            $query = $this->model;
            if (!empty($select)) {
                $query = $query->select($select);
            }
            return $query->whereIn('id', $userIds)->get();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Update user profile image
     *
     * @param array $params
     * @param int $id
     * @param string $profileType
     * @return bool
     */
    public function updateProfileImage(string $uploadFile, int $userId) //UploadedFile $uploadFile
    {
        $fileName                = uniqid() . ".jpeg";

        $storageDisk    = config('services.storage')['disk'];
        $uploadLocation = config('services.fileUploadPaths')['customerImageUploadPath'];

        /*  $resizeFolder   = [
            'COVER_IMAGE',
            'PROFILE_IMAGE',
            'THUMBNAIL_IMAGE',
        ]; */
        $isFileUploaded = $this->createImageFromBase64($uploadFile, $uploadLocation, $fileName, $storageDisk);

        if ($isFileUploaded) {
            $user = $this->model->find($userId);

            /* $pathArray=['collection','cover','original','post','profile','thumbnail'];

            if(isset($user->media->first()->file)){
                foreach ($pathArray as $path) {
                    if(file_exists(public_path().'/storage/images/'.$path.'/'.$user->media->first()->file)){
                        unlink(public_path().'/storage/images/'.$path.'/'.$user->media->first()->file);
                    }
                }
            } */
            $user->media()->where('is_profile_picture', true)->delete();
            $isProfilePictureRelatedMediaCreated = $user->media()->create([
                'mediaable_type'     => 'App\Models\User',
                'mediaable_id'       => $userId,
                'media_type'         => 'image',
                'file'               => $fileName,
                'is_profile_picture' => true
            ]);

            if ($isProfilePictureRelatedMediaCreated) {
                return $fileName;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function createOrUpdateCart($attributes)
    {
        // dd($attributes);
        $carts = auth()->user()->carts()->where('product_id', $attributes['product_id'])->whereJsonContains('attributes', $attributes['attributes'])->first();
        if (!empty($carts)) {
            return $carts->update([
                'quantity' => $carts->quantity + $attributes['quantity'],
            ]);
        } else {
            return auth()->user()->carts()->create([
                'product_id' => $attributes['product_id'],
                'attributes' => $attributes['attributes'],
                'quantity' => $attributes['quantity'],
            ]);
        }
    }



    public function getUsers($role)
    {
        return $this->model->whereHas('roles', function ($q) use ($role) {
            $q->where('role_type', $role);
        })->get();
    }
    public function getCustomersDashboard($role, $filterConditions, $limit)
    {
        return $this->model->whereHas('roles', function ($q) use ($role) {
            $q->where('role_type', $role);
        })->where($filterConditions)->paginate($limit);
    }
    public function getSellersDashboard($role, $filterConditions, $limit)
    {
        return $this->model->whereHas('roles', function ($q) use ($role) {
            $q->where('role_type', $role);
        })->where($filterConditions)->paginate($limit);
    }

    public function getEmployeeUsers($role, $type)
    {
        return $this->model->whereHas('roles', function ($q) use ($role, $type) {
            $q->where('slug', $role);
            $q->where('role_type', $type);
        })->get();
    }

    public function getAllUsers($filterConditions, $role, string $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)
    {
        return $this->model->whereHas('roles', function ($q) use ($role) {
            $q->where('slug', $role);
        })->where($filterConditions)->orderBy($orderBy, $sortBy)->get();
    }

    public function createCustomer($attributes)
    {
        $password = Str::random(8);
        $attributes['email_verified_at'] = auth()->user() ? \Carbon\Carbon::now() : '';
        $attributes['password'] = bcrypt($password);
        $attributes['is_approve'] =  auth()->user() ? 1 : 0;
        $attributes['is_blocked'] = 0;
        $isCustomerCreated = $this->create($attributes);

        if ($isCustomerCreated) {
            $isCustomerRole = $this->roleModel->where('slug', 'customer')->first();
            $isCustomerCreated->roles()->attach($isCustomerRole);
            /* create profile */
            $isCustomerCreated->profile()->create($attributes);
            if (isset($attributes['customer_image']) && $attributes['customer_image']) {
                $fileName = uniqid() . '.' . $attributes['customer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['customer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isCustomerCreated->media()->create([
                        'mediaable_type' => get_class($isCustomerCreated),
                        'mediaable_id' => $isCustomerCreated->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
            $mailParams                     = array();
            $mailParams['mail_type']        = 'seller_invite';
            $mailParams['to']               = $attributes['email'];
            $mailParams['password']         = $password;
            $mailParams['from']             = config('mail.from.address');
            $mailParams['subject']          = $isCustomerCreated->roles()->first()->name . ' Invitation from ' . env('APP_NAME');
            $mailParams['greetings']        = "Hello ! User";
            $mailParams['line']             = 'You have been invited to become an ' . $isCustomerCreated->roles()->first()->name . ' at ' . env('APP_NAME');
            $mailParams['content']          = "Click on the button below to login as an " . $isCustomerCreated->roles()->first()->name . ".";
            $mailParams['link']             = route('login');
            $mailParams['end_greetings']    = "Regards,";
            $mailParams['from_user']        = env('MAIL_FROM_NAME');
            Mail::send(new SendMailable($mailParams));
        }
        return $isCustomerCreated;
    }
    public function updateCustomer($attributes, $id)
    {
        $user = $this->find($id);
        if (!auth()->user()->hasRole('customer')) {
            $password = Str::random(8);
            $attributes['email_verified_at'] = \Carbon\Carbon::now();
            $attributes['password'] = bcrypt($password);
            $attributes['is_approve'] = 1;
        }

        $isCustomerUpdated = $user->update($attributes);

        if ($isCustomerUpdated) {
            $profileData['address'] = $attributes['address'] ?? NUll;
            $profileData['birthday'] = $attributes['birthday'] ?? NUll;
            $profileData['gender'] = $attributes['gender'] ?? NUll;
            $profileData['zipcode'] = $attributes['zipcode'] ?? NUll;
            $profileData['country'] = $attributes['country'] ?? NUll;
            $profileData['state'] = $attributes['state'] ?? NUll;
            $profileData['city'] = $attributes['city'] ?? NUll;

            /* create profile */
            $user->profile()->update($profileData);
            if (isset($attributes['customer_image']) && $attributes['customer_image']) {
                $fileName = uniqid() . '.' . $attributes['customer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['customer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_profile_picture' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
        }
        return $user;
    }

    public function registerCustomer($attributes)
    {

        $isCustomerCreated = $this->create($attributes);
        if ($isCustomerCreated) {
            $isCustomerCreated->profile()->create($attributes);
            $isCustomerRole = $this->roleModel->where('slug', 'customer')->first();
            $isCustomerCreated->roles()->sync($isCustomerRole->id);
        }
        return $isCustomerCreated;
    }

    /*public function createAgent($attributes){
        $isAgentCreated = $this->create([
            'first_name' 		=> $attributes['first_name'],
    		'last_name' 		=> $attributes['last_name'],
            'mobile_number' 	=> $attributes['mobile_number'],
            'email'             => $attributes['email'],
            'email_verified_at' => \Carbon\Carbon::now(),
            'password'          => bcrypt($attributes['password']),
            'is_approve'        => 1
        ]);

        if($isAgentCreated){

            $isAgentRole= $this->roleModel->where('slug','delivery-agent')->first();
            $isAgentCreated->roles()->sync($isAgentRole->id);
            // create profile
            $isAgentCreated->profile()->create($attributes);
            if (isset($attributes['agent_image'])) {
                $fileName = uniqid() . '.' . $attributes['agent_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['agent_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isAgentCreated->media()->create([
                        'mediaable_type' => get_class($isAgentCreated),
                        'mediaable_id' => $isAgentCreated->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
            if (isset($attributes['document_file'])) {
                $fileName = uniqid() . '.' . $attributes['document_file']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['document_file'], config('constants.SITE_AGENT_DOCUMENT_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                        $isFileRelatedMediaCreated = $isAgentCreated->document()->create([
                            'title'=> $attributes['title'],
                            'documentable_type ' => get_class($isAgentCreated),
                            'documentable_id ' => $isAgentCreated->id,
                            'document_type' => 'document',
                            'file' => $fileName,
                        ]);
                }
            }
            $mailParams                     = array();
            $mailParams['mail_type']        = 'seller_invite';
            $mailParams['to']               = $attributes['email'];
            $mailParams['password']         = $attributes['password'];
            $mailParams['from']             = config('mail.from.address');
            $mailParams['subject']          = $isAgentCreated->roles()->first()->name.' Invitation from '.env('APP_NAME');
            $mailParams['greetings']        = "Hello ! User";
            $mailParams['line']             = 'You have been invited to become an '.$isAgentCreated->roles()->first()->name.' at ' . env('APP_NAME');
            $mailParams['content']          = "Click on the button below to login as an ".$isAgentCreated->roles()->first()->name.".";
            $mailParams['link']             = route('login');
            $mailParams['end_greetings']    = "Regards,";
            $mailParams['from_user']        = env('MAIL_FROM_NAME');
            Mail::send(new SendMailable($mailParams));
        }
        return $isAgentCreated;
    }

    public function updateAgent($attributes,$id){
        $user = $this->find($id);
        $isAgentCreated = $user->update([
            'first_name' 		=> $attributes['first_name'],
    		'last_name' 		=> $attributes['last_name'],
            'mobile_number' 	=> $attributes['mobile_number'],
            // 'email'             => $attributes['email'],
            'email_verified_at' => \Carbon\Carbon::now(),
            // 'password'          => bcrypt($attributes['password']),
            'is_approve'        => 1
        ]);

        if($isAgentCreated){
            $profileData['address'] = $attributes['address'];
            $profileData['zipcode'] = $attributes['zipcode'];
            // create profile
            $user->profile()->update($profileData);
            if (isset($attributes['agent_image'])) {
                $fileName = uniqid() . '.' . $attributes['agent_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['agent_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id'=>$id,'is_profile_picture'=>true],[
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
            if (isset($attributes['document_file'])) {
                $fileName = uniqid() . '.' . $attributes['document_file']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['document_file'], config('constants.SITE_AGENT_DOCUMENT_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                        $isFileRelatedMediaCreated = $user->document()->updateOrCreate(['documentable_id'=>$id],[
                            'title'=> $attributes['title'],
                            'documentable_type ' => get_class($user),
                            'documentable_id ' => $user->id,
                            'document_type' => 'document',
                            'file' => $fileName,
                        ]);
                }
            }

        }
        return $user;
    }*/
    /**
     * Create an admin
     *
     * @param array $params
     * @return mixed
     */
    public function createAdmin(array $params)
    {
        $user = $this->create([
            'first_name'         => $params['first_name'],
            'last_name'         => $params['last_name'],
            'mobile_number'     => $params['mobile_number'],
            'email'             => $params['email'],
            'email_verified_at' => \Carbon\Carbon::now(),
            'password'          => bcrypt($params['password']),
            'is_approve'        => 1
        ]);
        ## Admin role and permission
        if ($user) {
            $user->roles()->sync($params['role_id']);
            $user->profile()->create([
                'address' => $params['address'],
                'organization_name' => $params['organization_name'],
                'designation' => $params['designation']
            ]);
            if (isset($params['seller_image'])) {
                $fileName = uniqid() . '.' . $params['seller_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($params['seller_image'], config('constants.SITE_ORIGINAL_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $user->media()->create([
                        'user_id' => $user->id,
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
            if (isset($params['document'])) {
                foreach ($params['document'] as $documents) {
                    $fileName = uniqid() . '.' . $documents['file']->getClientOriginalExtension();
                    $title = $documents['title'];
                    $isFileUploaded = $this->uploadOne($documents['file'], config('constants.SITE_SELLER_DOCUMENT_UPLOAD_PATH'), $fileName, 'public');
                    if ($isFileUploaded) {
                        $isFileRelatedMediaCreated = $user->document()->create([
                            'title' => $title,
                            'documentable_type ' => get_class($user),
                            'documentable_id ' => $user->id,
                            'document_type' => 'document',
                            'file' => $fileName,
                        ]);
                    }
                }
            }

            $mailParams                     = array();
            $mailParams['mail_type']        = 'seller_invite';
            $mailParams['to']               = $params['email'];
            $mailParams['password']         = $params['password'];
            $mailParams['from']             = config('mail.from.address');
            $mailParams['subject']          = $user->roles()->first()->name . ' Invitation from ' . env('APP_NAME');
            $mailParams['greetings']        = "Hello ! User";
            $mailParams['line']             = 'You have been invited to become an ' . $user->roles()->first()->name . ' at ' . env('APP_NAME');
            $mailParams['content']          = "Click on the button below to login as an " . $user->roles()->first()->name . ".";
            $mailParams['link']             = route('login');
            $mailParams['end_greetings']    = "Regards,";
            $mailParams['from_user']        = env('MAIL_FROM_NAME');
            Mail::send(new SendMailable($mailParams));
        }
        return $user;
    }


    public function updateStatus(array $attributes)
    {
        return $this->update(['is_active' => $attributes['is_active']], $attributes['id']);
    }



    public function findAddress(int $id)
    {
        return $this->addressModel->find($id);
    }

    public function updateAddress(array $attributes, int $id)
    {
        $address = $this->addressModel->find($id);
        $isAddressUpdated = $address->update($attributes);
        if ($isAddressUpdated) {
            return $address;
        } else {
            return false;
        }
    }

    public function createAddress(array $attributes)
    {
        return $this->find(auth()->user()->id)->addresses()->create($attributes);
    }

    public function deleteAddress($id)
    {
        return $this->addressModel->find($id)->delete();
    }












    /*************************************************** */



    /*ADMIN PART TEMP*/






    /**
     * Get user details by id
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|mixed
     */
    public function findDetails(int $id)
    {
        $params = ['id' => $id];
        return $this->findOneBy($params);
    }

    /**
     * Deactivating a user account and generating log
     *
     * @param array $data
     * @param int $id
     * @return mixed|null
     */
    public function deactivateUserAccount(array $data, int $id)
    {
        $params = $data['userData'];
        $deactivateLogsParams = $data['deactivateLogData'];
        $user = $this->update($params, $id);

        return true;
    }

    /**
     * Get count of total pages
     *
     * @param null $search
     * @return mixed
     */
    public function getTotalUsers($search = null)
    {
        // dd($search);
        $query = $this->model;
        if($search) {
            $query = $query->where('first_name','LIKE',"%{$search}%")
                           ->orWhere('last_name', 'LIKE',"%{$search}%")
                           //->orWhere('username','LIKE',"%{$search}%")
                           ->orWhere('email','LIKE',"%{$search}%")
                           ->orWhere('mobile_number', 'LIKE', "%{$search}%")
                            ->orWhereHas('categories', function ($q) use ($search) {
                                $q->where('name', 'LIKE', "%{$search}%");
                            });
        }

        return $query->count();
    }

    public function getUsersTotal($role,$slug,$status='all',$search=null){
        /*$query = $this->model;
        $query= $query->whereHas('vehicle',function($q)use($slug){
            $q->whereHas('vehicleType',function($qu)use($slug){
                $qu->where('slug',$slug);
            });
        })->whereHas('roles',function($r)use($role){
            $r->where('slug',$role);
        });
        $query->where('is_registered', 1);
        if($status != 'all'){
            $query->where('is_active', $status);
        }
        if($search) {
            $query = $query->where('first_name','LIKE',"%{$search}%")
                            ->orWhere('last_name', 'LIKE',"%{$search}%")
            //->orWhere('username','LIKE',"%{$search}%")
                            ->orWhere('email','LIKE',"%{$search}%")
                            ->orWhere('mobile_number', 'LIKE', "%{$search}%")
                            ->orWhereHas('categories', function ($q) use ($search) {
                                $q->where('name', 'LIKE', "%{$search}%");
                            })
                            ->orWhereHas('vehicle', function ($q) use ($search) {
                                $q->where('registration_number', 'LIKE', "%{$search}%")
                                ->orWhereHas('vehicleType', function ($qr) use ($search) {
                                    $qr->where('name', 'LIKE', "%{$search}%");
                                })
                                ->orWhereHas('vehicleSubType', function ($qr) use ($search) {
                                    $qr->where('name', 'LIKE', "%{$search}%");
                                })
                                ->orWhereHas('vehicleBodyType', function ($qr) use ($search) {
                                    $qr->where('name', 'LIKE', "%{$search}%");
                                });
                            });
        }
        return $query->count();*/

        $model = $this->model;
        $model= $model->whereHas('vehicle',function($q)use($slug){
            $q= $q->whereHas('vehicleType',function($qu)use($slug){
                $qu= $qu->where('slug',$slug);
            });
        })->whereHas('roles',function($r)use($role){
            $r= $r->where('slug',$role);
        });
        $model->where('is_registered', 1);
        if($status != 'all'){
            $model->where('is_active', $status);
        }
        //dd($filterConditions);
        if ($search) {
            $model = $model->where(function ($model) use ($search) {
                $model->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('mobile_number', 'LIKE', "%{$search}%")
                    ->orWhereHas('vehicle', function ($q) use ($search) {
                        $q->where('registration_number', 'LIKE', "%{$search}%")
                        ->orWhereHas('vehicleType', function ($qr) use ($search) {
                            $qr->where('name', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('vehicleSubType', function ($qr) use ($search) {
                            $qr->where('name', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('vehicleBodyType', function ($qr) use ($search) {
                            $qr->where('name', 'LIKE', "%{$search}%");
                        });
                    });
            });
        }
        return $model->count();
    }

    public function findUserByRole(array $filterConditions,string $role,string $orderBy = 'id', string $sortBy = 'asc',$limit= null,$offset=null,$inRandomOrder=false,$search=null)
    {
        // dd($filterConditions);
        $model = $this->model->whereHas('roles', function (Builder $query) use ($role) {
            $query->where('slug', $role);
        });
        if ($filterConditions) {
            $model = $model->where($filterConditions);
        }
        if ($search) {
            $model = $model->where(function ($model) use ($search) {
                $model->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('mobile_number', 'LIKE', "%{$search}%");
            });
        }

        if ($inRandomOrder) {
            $model = $model->inRandomOrder();
        } else {
            $model = $model->orderBy($orderBy, $sortBy);
        }
        if ($offset ) {
            $model = $model->offset($offset);
        }
        if ($limit) {
            $model = $model->limit($limit);
        }
        // dd($model->toRawSql());
        // dd($model->get());

        return $model->get();
    }

    public function findUserByRoleAndCategory(array $filterConditions, string $role, string $slug, string $orderBy = 'id', string $sortBy = 'asc', $limit = null, $offset = null, $inRandomOrder = false, $search = null)
    {
        $model = $this->model;
        $model= $model->whereHas('vehicle',function($q)use($slug){
            $q= $q->whereHas('vehicleType',function($qu)use($slug){
                $qu= $qu->where('slug',$slug);
            });
        })->whereHas('roles',function($r)use($role){
            $r= $r->where('slug',$role);
        });
        if (!is_null($filterConditions)) {
            $model = $model->where($filterConditions);
        }
        //dd($filterConditions);
        if ($search) {
            $model = $model->where(function ($model) use ($search) {
                $model->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('mobile_number', 'LIKE', "%{$search}%")
                    ->orWhereHas('vehicle', function ($q) use ($search) {
                        $q->where('registration_number', 'LIKE', "%{$search}%")
                        ->orWhereHas('vehicleType', function ($qr) use ($search) {
                            $qr->where('name', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('vehicleSubType', function ($qr) use ($search) {
                            $qr->where('name', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('vehicleBodyType', function ($qr) use ($search) {
                            $qr->where('name', 'LIKE', "%{$search}%");
                        });
                    });
            });
        }

        if ($inRandomOrder) {
            $model = $model->inRandomOrder();
        } else {
            $model = $model->orderBy($orderBy, $sortBy);
        }
        if ($offset) {
            $model = $model->offset($offset);
        }

        if (!is_null($limit)) {
            $model = $model->limit($limit);
        }
        //dd($model->get());
        return $model->get();
    }

    public function createUser(array $attributes)
    {
        $isUserCreated = $this->create($attributes);
        if ($isUserCreated) {
            $isUserCreated->profile()->create([
                'gender' => $attributes['gender'] ?? '',
            ]);
            $role = $this->roleModel->where('slug', $attributes['role'])->get();
            $isUserCreated->roles()->attach($role);

            if (isset($attributes['image']) && $attributes['image']) {
                $fileName = uniqid() . '.' . $attributes['image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isUserCreated->media()->create([
                        'mediaable_type' => get_class($isUserCreated),
                        'mediaable_id' => $isUserCreated->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true
                    ]);
                }
            }
            if (isset($attributes['aadhar_front']) && $attributes['aadhar_front']) {
                $fileName = uniqid() . '.' . $attributes['aadhar_front']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['aadhar_front'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isUserCreated->media()->create([
                        'mediaable_type' => get_class($isUserCreated),
                        'mediaable_id' => $isUserCreated->id,
                        'media_type' => 'aadhar_front',
                        'file' => $fileName,
                        'is_profile_picture' => false
                    ]);
                }
            }
            if (isset($attributes['aadhar_back']) && $attributes['aadhar_back']) {
                $fileName = uniqid() . '.' . $attributes['aadhar_back']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['aadhar_back'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isUserCreated->media()->create([
                        'mediaable_type' => get_class($isUserCreated),
                        'mediaable_id' => $isUserCreated->id,
                        'media_type' => 'aadhar_back',
                        'file' => $fileName,
                        'is_profile_picture' => false
                    ]);
                }
            }
            if (isset($attributes['licence_front']) && $attributes['licence_front']) {
                $fileName = uniqid() . '.' . $attributes['licence_front']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['licence_front'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isUserCreated->media()->create([
                        'mediaable_type' => get_class($isUserCreated),
                        'mediaable_id' => $isUserCreated->id,
                        'media_type' => 'licence_front',
                        'file' => $fileName,
                        'is_profile_picture' => false
                    ]);
                }
            }
            if (isset($attributes['licence_back']) && $attributes['licence_back']) {
                $fileName = uniqid() . '.' . $attributes['licence_back']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['licence_back'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isUserCreated->media()->create([
                        'mediaable_type' => get_class($isUserCreated),
                        'mediaable_id' => $isUserCreated->id,
                        'media_type' => 'licence_back',
                        'file' => $fileName,
                        'is_profile_picture' => false
                    ]);
                }
            }

            if(isset($attributes['email']) && $attributes['email']){
                $mailData =[
                    'to' => $attributes['email'],
                    'from' => env('MAIL_FROM_ADDRESS'),
                    'mail_type' => 'information',
                    'line' => 'Welcome To Natural Fitness Portal',
                    'content' => 'Your account has been successfully created. Please change your password once you login into our portal',
                    'subject' => 'Credentials for Login',
                    'password' => $attributes['mobile_number'],
                    'greetings' => 'Hello Sir/Madam',
                    'link' => route('login')
                ];
                Mail::send(new SendMailable($mailData));
            }
        }
        return $isUserCreated;
    }

    public function updateUser(array $attributes, int $id)
    {
        $isUser = $this->find($id);
        $isUserUpdated = $isUser->update($attributes);
        if ($isUserUpdated) {

            $isUser->profile()->update([
                'gender' => $attributes['gender'] ?? '',
                // 'occupation' => $attributes['occupation'] ?? ''
            ]);

            $role = $this->roleModel->where('slug', $attributes['role'])->get();
            $isUser->roles()->sync($role);

            if (isset($attributes['image']) && $attributes['image']) {
                $fileName = uniqid() . '.' . $attributes['image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreatedOrUpdated = $isUser->media()->updateOrCreate(['user_id'=>$id,'media_type'=>'image'], [
                        'mediaable_type' => get_class($isUser),
                        'mediaable_id' => $isUser->id,
                        'user_id' => $isUser->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'alt_text' => $attributes['alt_text'] ?? null,
                        'is_profile_picture' => true,
                    ]);
                }
            }

            if (isset($attributes['aadhar_front']) && $attributes['aadhar_front']) {
                $fileName = uniqid() . '.' . $attributes['aadhar_front']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['aadhar_front'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreatedOrUpdated = $isUser->media()->updateOrCreate(['user_id' => $id,'media_type'=>'aadhar_front'], [
                        'mediaable_type' => get_class($isUser),
                        'mediaable_id' => $isUser->id,
                        'user_id' => $isUser->id,
                        'media_type' => 'aadhar_front',
                        'file' => $fileName,
                        'alt_text' => $attributes['alt_text'] ?? null,
                        'is_profile_picture' => false,
                        'is_approve' => $attributes['is_aadhar_approve'] ?? null,
                    ]);
                }
            }
            if (isset($attributes['aadhar_back']) && $attributes['aadhar_back']) {
                $fileName = uniqid() . '.' . $attributes['aadhar_back']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['aadhar_back'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreatedOrUpdated = $isUser->media()->updateOrCreate(['user_id' => $id,'media_type'=>'aadhar_back'], [
                        'mediaable_type' => get_class($isUser),
                        'mediaable_id' => $isUser->id,
                        'user_id' => $isUser->id,
                        'media_type' => 'aadhar_back',
                        'file' => $fileName,
                        'alt_text' => $attributes['alt_text'] ?? null,
                        'is_profile_picture' => false,
                        'is_approve' => $attributes['is_aadhar_approve'] ?? null,
                    ]);
                }
            }
            if (isset($attributes['licence_front']) && $attributes['licence_front']) {
                $fileName = uniqid() . '.' . $attributes['licence_front']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['licence_front'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreatedOrUpdated = $isUser->media()->updateOrCreate(['user_id' => $id,'media_type'=>'licence_front'], [
                        'mediaable_type' => get_class($isUser),
                        'mediaable_id' => $isUser->id,
                        'user_id' => $isUser->id,
                        'media_type' => 'licence_front',
                        'file' => $fileName,
                        'alt_text' => $attributes['alt_text'] ?? null,
                        'is_profile_picture' => false,
                        'is_approve' => $attributes['is_licence_approve'] ?? null,
                    ]);
                }
            }
            if (isset($attributes['licence_back']) && $attributes['licence_back']) {
                $fileName = uniqid() . '.' . $attributes['licence_back']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['licence_back'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreatedOrUpdated = $isUser->media()->updateOrCreate(['user_id' => $id,'media_type'=>'licence_back'], [
                        'mediaable_type' => get_class($isUser),
                        'mediaable_id' => $isUser->id,
                        'user_id' => $isUser->id,
                        'media_type' => 'licence_back',
                        'file' => $fileName,
                        'alt_text' => $attributes['alt_text'] ?? null,
                        'is_profile_picture' => false,
                        'is_approve' => $attributes['is_licence_approve'] ?? null,
                    ]);
                }
            }
        }
        return $isUserUpdated;
    }

    public function createDriver(array $attributes, int $id)
    {
        $splitName = explode(' ', $attributes['name'], 2); // Restricts it to only 2 values, for names like Billy Bob Jones
        $data['first_name'] = $splitName[0];
        $data['last_name'] = !empty($splitName[1]) ? $splitName[1] : '';
        $data['email'] = $attributes['email'];
        $isUser = $this->find($id);
        $isUserUpdated = $isUser->update($data);
        if ($isUserUpdated) {
            if (isset($attributes['image']) && $attributes['image']) {
                $fileName = uniqid() . '.' . $attributes['image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $userImage = Media::create([
                        'user_id' => $isUser->id,
                        'mediaable_type' => get_class($isUser),
                        'mediaable_id' => $id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'alt_text' => $attributes['alt_text'] ?? null,
                        'is_profile_picture' => true,
                    ]);
                }
            }
            if (isset($attributes['aadhar_image']) && $attributes['aadhar_image']) {
                $fileName = uniqid() . '.' . $attributes['aadhar_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['aadhar_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $aadharImage = Media::create([
                        'user_id' => $isUser->id,
                        'mediaable_type' => get_class($isUser),
                        'mediaable_id' => $id,
                        'media_type' => 'aadhar_image',
                        'file' => $fileName,
                        'alt_text' => $attributes['alt_text'] ?? null,
                        'is_profile_picture' => false,
                    ]);
                }
            }
            if (isset($attributes['license_image']) && $attributes['license_image']) {
                $fileName = uniqid() . '.' . $attributes['license_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['license_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $licenseImage = Media::create([
                        'user_id' => $isUser->id,
                        'mediaable_type' => get_class($isUser),
                        'mediaable_id' => $id,
                        'media_type' => 'license_image',
                        'file' => $fileName,
                        'alt_text' => $attributes['alt_text'] ?? null,
                        'is_profile_picture' => false,
                    ]);
                }
            }
        }
        return $isUserUpdated;
    }

    public function createCouncil(array $attributes)
    {
        //$password = Str::random(8);
        $password = 'secret';
        $attributes['email_verified_at'] = auth()->user() ? \Carbon\Carbon::now() : '';
        $attributes['password'] = bcrypt($password);
        $attributes['is_approve'] =  auth()->user() ? 1 : 0;
        $attributes['is_blocked'] = 0;
        $isUserCreated = $this->create($attributes);
        if ($isUserCreated) {
            $isUserCreated->profile()->create([
                'gender' => $attributes['gender'] ?? '',
            ]);

            if ($isUserCreated) {
                $role = $this->roleModel->where('slug', $attributes['role'])->get();
                $isUserCreated->roles()->attach($role);
                /* create profile */
                if (isset($attributes['image'])) {
                    $fileName = uniqid() . '.' . $attributes['image']->getClientOriginalExtension();
                    $isFileUploaded = $this->uploadOne($attributes['image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                    if ($isFileUploaded) {
                        $isFileRelatedMediaCreated = $isUserCreated->media()->create([
                            'mediaable_type' => get_class($isUserCreated),
                            'mediaable_id' => $isUserCreated->id,
                            'media_type' => 'image',
                            'file' => $fileName,
                            'is_profile_picture' => true
                        ]);
                    }
                }
                $mailData = [
                    'to' => $attributes['email'],
                    'from' => env('MAIL_FROM_ADDRESS'),
                    'mail_type' => 'information',
                    'line' => 'Welcome To Natural Fitness Portal',
                    'content' => 'Your account has been successfully created. Please change your password once you login into our portal',
                    'subject' => 'Credentials for Login',
                    'password' => $password,
                    'greetings' => 'Hello Sir/Madam',
                    'link' => route('council.login')
                ];
                Mail::send(new SendMailable($mailData));
            }
        }
        return $isUserCreated;
    }

    public function updateCouncil(array $attributes, int $id)
    {
        $isUser = $this->find($id);
        $isUserUpdated = $isUser->update($attributes);
        //dd($isUserUpdated);
        if ($isUserUpdated) {
            if (isset($attributes['image'])) {
                $fileName = uniqid() . '.' . $attributes['image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreatedOrUpdated = $isUser->image()->updateOrCreate(['mediaable_id' => $id], [
                        'user_id' => $isUser->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'alt_text' => $attributes['alt_text'] ?? null,
                        'is_profile_picture' => true,
                    ]);
                }
            }
        }
        return $isUserUpdated;
    }
    public function createAgent(array $attributes)
    {
        //$password = Str::random(8);
        $password = 'secret';
        $attributes['email_verified_at'] = auth()->user() ? \Carbon\Carbon::now() : '';
        $attributes['password'] = bcrypt($password);
        $attributes['is_approve'] =  auth()->user() ? 1 : 0;
        $attributes['is_blocked'] = 0;
        $isUserCreated = $this->create($attributes);
        if ($isUserCreated) {
            $isUserCreated->profile()->create([
                'gender' => $attributes['gender'] ?? '',
            ]);

            if ($isUserCreated) {
                $role = $this->roleModel->where('slug', $attributes['role'])->get();
                $isUserCreated->roles()->attach($role);
                /* create profile */
                if (isset($attributes['image'])) {
                    $fileName = uniqid() . '.' . $attributes['image']->getClientOriginalExtension();
                    $isFileUploaded = $this->uploadOne($attributes['image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                    if ($isFileUploaded) {
                        $isFileRelatedMediaCreated = $isUserCreated->media()->create([
                            'mediaable_type' => get_class($isUserCreated),
                            'mediaable_id' => $isUserCreated->id,
                            'media_type' => 'image',
                            'file' => $fileName,
                            'is_profile_picture' => true
                        ]);
                    }
                }
                $mailData = [
                    'to' => $attributes['email'],
                    'from' => env('MAIL_FROM_ADDRESS'),
                    'mail_type' => 'information',
                    'line' => 'Welcome To Natural Fitness Portal',
                    'content' => 'Your account has been successfully created. Please change your password once you login into our portal',
                    'subject' => 'Credentials for Login',
                    'password' => $password,
                    'greetings' => 'Hello Sir/Madam',
                    'link' => route('agent.login')
                ];
                Mail::send(new SendMailable($mailData));
            }
        }
        return $isUserCreated;
    }

    public function updateAgent(array $attributes, int $id)
    {
        $isUser = $this->find($id);
        $isUserUpdated = $isUser->update($attributes);
        //dd($isUserUpdated);
        if ($isUserUpdated) {
            if (isset($attributes['image'])) {
                $fileName = uniqid() . '.' . $attributes['image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreatedOrUpdated = $isUser->image()->updateOrCreate(['mediaable_id' => $id], [
                        'user_id' => $isUser->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'alt_text' => $attributes['alt_text'] ?? null,
                        'is_profile_picture' => true,
                    ]);
                }
            }
        }
        return $isUserUpdated;
    }

    public function findUsersByCreatedBy(array $filterConditions, string $createdBy, string $orderBy = 'id', string $sortBy = 'asc', $limit = null, $offset = null, $inRandomOrder = false, $search = null)
    {
        // dd($search);
        $model = $this->model->where('created_by', $createdBy);

        if (!is_null($filterConditions)) {
            $model = $model->where($filterConditions);
        }
        if ($search) {
            $model = $model->where(function ($model) use ($search) {
                $model->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('mobile_number', 'LIKE', "%{$search}%");
            });
        }

        if ($inRandomOrder) {
            $model = $model->inRandomOrder();
        } else {
            $model = $model->orderBy($orderBy, $sortBy);
        }
        if ($offset) {
            $model = $model->offset($offset);
        }

        if (!is_null($limit)) {
            $model = $model->limit($limit);
        }
        return $model->get();
    }

    public function userSupportDetails()
    {
        $data = $this->model->has('support')->get();
        return $data;
    }

    public function addBrandingHistory(array $attributes)
    {
        $isHistoryCreated = $this->brandingHistoryModel->create($attributes);
        return $isHistoryCreated;
    }

    public function findDeletedUserByRole(array $filterConditions, string $role, string $orderBy = 'id', string $sortBy = 'asc', $limit = null, $offset = null, $inRandomOrder = false, $search = null)
    {
        $model = $this->model->onlyTrashed()->whereHas('roles', function (Builder $query) use ($role) {
            $query->where('slug', $role);
        });
        if (!is_null($filterConditions)) {
            $model = $model->where($filterConditions);
        }
        if ($search) {
            $model = $model->where(function ($model) use ($search) {
                $model->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('mobile_number', 'LIKE', "%{$search}%")
                    ->orWhereHas('vehicle', function ($q) use ($search) {
                        $q->where('registration_number', 'LIKE', "%{$search}%")
                        ->orWhereHas('vehicleType', function ($qr) use ($search) {
                            $qr->where('name', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('vehicleSubType', function ($qr) use ($search) {
                            $qr->where('name', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('vehicleBodyType', function ($qr) use ($search) {
                            $qr->where('name', 'LIKE', "%{$search}%");
                        });
                    });
            });
        }

        if ($inRandomOrder) {
            $model = $model->inRandomOrder();
        } else {
            $model = $model->orderBy($orderBy, $sortBy);
        }
        if ($offset) {
            $model = $model->offset($offset);
        }

        if (!is_null($limit)) {
            $model = $model->limit($limit);
        }
        //dd($model->get());
        return $model->get();
    }
    public function findReferrals(array $filterConditions,string $orderBy = 'id', string $sortBy = 'asc',$limit= null,$offset=null,$inRandomOrder=false,$search=null)
    {
        // dd($filterConditions);
        $model = $this->referralModel;
        if ($filterConditions) {
            $model = $model->where($filterConditions);
        }
        if ($search) {
            $model = $model->where(function ($model) use ($search) {
                $model->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('mobile_number', 'LIKE', "%{$search}%")
                    ->orWhere('ibd_number', 'LIKE', "%{$search}%")
                    ->orWhere('type', 'LIKE', "%{$search}%")
                    ->orWhereHas('referencePlatform', function (Builder $query) use ($search) {
                        $query->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('referredUser', function (Builder $query) use ($search) {
                        $query->where('first_name', 'LIKE', "%{$search}%")
                            ->orWhere('first_name', 'LIKE', "%{$search}%");
                    });
            });
        }

        if ($inRandomOrder) {
            $model = $model->inRandomOrder();
        } else {
            $model = $model->orderBy($orderBy, $sortBy);
        }
        if ($offset ) {
            $model = $model->offset($offset);
        }
        if ($limit) {
            $model = $model->limit($limit);
        }
        // dd($model->toRawSql());
        // dd($model->get());

        return $model->get();
    }
    public function createReferral(array $attributes)
    {
        $isReferralCreated = $this->referralModel->create($attributes);
        return $isReferralCreated;
    }
    public function updateReferral(array $attributes, int $id)
    {
        $isReferral = $this->referralModel->find($id);
        $isReferralUpdated = $isReferral->update($attributes);
        return $isReferralUpdated;
    }
    public function findReferralById(int $id)
    {
        return $this->referralModel->find($id);
    }
}

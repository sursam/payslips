<?php
namespace App\Repositories\Users;

use App\Contracts\Users\UserContract;
use App\Mail\SendMailable;
use App\Models\Address;
use App\Models\Document;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
    /**
     * UserRepository constructor.
     * @param User $model
     * @param Document $documentModel
     * @param Role $roleModel
     * @param Address $addressModel
     * @param Product $productModel
     */
    public function __construct(
        User $model,
        Document $documentModel,
        Role $roleModel,
        Address $addressModel,
        Product $productModel
    ) {
        parent::__construct($model);
        $this->model = $model;
        $this->documentModel = $documentModel;
        $this->roleModel = $roleModel;
        $this->addressModel = $addressModel;
        $this->productModel = $productModel;
    }

    public function findUsers($profileType, $filterConditions = null,
        $orderBy = 'id', $sortBy = 'desc', $limit = null, $inRandomOrder = false) {
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

    public function userSearch($profileType, $filterConditions = null,
        $orderBy = 'id', $sortBy = 'desc', $limit = null, $inRandomOrder = false) {
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
        $fileName = uniqid() . ".jpeg";

        $storageDisk = config('services.storage')['disk'];
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
                'mediaable_type' => 'App\Models\User',
                'mediaable_id' => $userId,
                'media_type' => 'image',
                'file' => $fileName,
                'is_profile_picture' => true,
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
            $q->whereNotIn('role_type', $role);
        })->where($filterConditions)->orderBy($orderBy, $sortBy)->get();

    }

    public function createCustomer($attributes)
    {
        $password = Str::random(8);
        $attributes['email_verified_at'] = auth()->user()?\Carbon\Carbon::now() : '';
        $attributes['password'] = bcrypt($password);
        $attributes['is_approve'] = auth()->user() ? 1 : 0;
        $attributes['is_blocked'] = 0;
        $isCustomerCreated = $this->create($attributes);

        if ($isCustomerCreated) {
            $isCustomerRole = $this->roleModel->where('slug', 'customer')->first();
            $isCustomerCreated->roles()->sync($isCustomerRole->id);
            /* create profile */
            $isCustomerCreated->profile()->create($attributes);
            if (isset($attributes['customer_image'])) {
                $fileName = uniqid() . '.' . $attributes['customer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['customer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isCustomerCreated->media()->create([
                        'mediaable_type' => get_class($isCustomerCreated),
                        'mediaable_id' => $isCustomerCreated->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true,
                    ]);
                }
            }
            $mailParams = array();
            $mailParams['mail_type'] = 'seller_invite';
            $mailParams['to'] = $attributes['email'];
            $mailParams['password'] = $password;
            $mailParams['from'] = config('mail.from.address');
            $mailParams['subject'] = $isCustomerCreated->roles()->first()->name . ' Invitation from ' . env('APP_NAME');
            $mailParams['greetings'] = "Hello ! User";
            $mailParams['line'] = 'You have been invited to become an ' . $isCustomerCreated->roles()->first()->name . ' at ' . env('APP_NAME');
            $mailParams['content'] = "Click on the button below to login as an " . $isCustomerCreated->roles()->first()->name . ".";
            $mailParams['link'] = route('login');
            $mailParams['end_greetings'] = "Regards,";
            $mailParams['from_user'] = env('MAIL_FROM_NAME');
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
            $profileData['address'] = $attributes['address'] ?? null;
            $profileData['birthday'] = $attributes['birthday'] ?? null;
            $profileData['gender'] = $attributes['gender'] ?? null;
            $profileData['zipcode'] = $attributes['zipcode'] ?? null;
            $profileData['country'] = $attributes['country'] ?? null;
            $profileData['state'] = $attributes['state'] ?? null;
            $profileData['city'] = $attributes['city'] ?? null;

            /* create profile */
            $user->profile()->update($profileData);
            if (isset($attributes['customer_image'])) {
                $fileName = uniqid() . '.' . $attributes['customer_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['customer_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_profile_picture' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true,
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

    public function createAgent($attributes)
    {
        $isAgentCreated = $this->create([
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'] ?? '',
            'mobile_number' => $attributes['mobile_number'],
            'email' => $attributes['email'],
            'email_verified_at' => \Carbon\Carbon::now(),
            'password' => bcrypt($attributes['password']),
            'is_active' => auth()->user() ? 1 : 0,
            'is_approve' => auth()->user() ? 1 : 0,
        ]);

        if ($isAgentCreated) {
            $isAgentRole = $this->roleModel->where('slug', 'delivery-agent')->first();
            if (!$isAgentRole) {
                $isAgentRole = $this->roleModel->create(['name' => 'Delivery Agent', 'short_code' => 'DA', 'role_type' => 'employee']);
            }

            $isAgentCreated->roles()->sync($isAgentRole->id);
            /* create profile */
            $isAgentCreated->profile()->create($attributes);
            $isAgentCreated->account()->create($attributes['bank_details']);
            if (isset($attributes['agent_image'])) {
                $fileName = uniqid() . '.' . $attributes['agent_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['agent_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isAgentCreated->media()->create([
                        'mediaable_type' => get_class($isAgentCreated),
                        'mediaable_id' => $isAgentCreated->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true,
                    ]);
                }
            }
            if (isset($attributes['document_file'])) {
                $fileName = uniqid() . '.' . $attributes['document_file']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['document_file'], config('constants.SITE_AGENT_DOCUMENT_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $isAgentCreated->document()->create([
                        'title' => $attributes['title'] ?? 'Driving Licence',
                        'document_type' => 'Licence Document',
                        'file' => $fileName,
                        'status' => auth()->user() ? true : false,
                    ]);
                }
            }
            if (auth()->user()) {
                $mailParams = array();
                $mailParams['mail_type'] = 'seller_invite';
                $mailParams['to'] = $attributes['email'];
                $mailParams['password'] = $attributes['password'];
                $mailParams['from'] = config('mail.from.address');
                $mailParams['subject'] = $isAgentCreated->roles()->first()->name . ' Invitation from ' . env('APP_NAME');
                $mailParams['greetings'] = "Hello ! User";
                $mailParams['line'] = 'You have been invited to become an ' . $isAgentCreated->roles()->first()->name . ' at ' . env('APP_NAME');
                $mailParams['content'] = "Click on the button below to download the app";
                $mailParams['link'] = 'https://canably-pwa.netlify.app/';
                $mailParams['button'] = 'Download';
                $mailParams['end_greetings'] = "Regards,";
                $mailParams['from_user'] = env('MAIL_FROM_NAME');
                Mail::send(new SendMailable($mailParams));
            }
        }
        return $isAgentCreated;
    }

    public function updateAgent($attributes, $id)
    {
        $user = $this->find($id);
        $isAgentCreated = $user->update([
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'mobile_number' => $attributes['mobile_number'],
            // 'email'             => $attributes['email'],
            'email_verified_at' => \Carbon\Carbon::now(),
            // 'password'          => bcrypt($attributes['password']),
            'is_approve' => 1,
        ]);

        if ($isAgentCreated) {
            $profileData['address'] = $attributes['address'];
            $profileData['zipcode'] = $attributes['zipcode'];
            /* create profile */
            $user->profile()->update($profileData);
            if (isset($attributes['agent_image'])) {
                $fileName = uniqid() . '.' . $attributes['agent_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['agent_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['user_id' => $id, 'is_profile_picture' => true], [
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true,
                    ]);
                }
            }
            if (isset($attributes['document_file'])) {
                $fileName = uniqid() . '.' . $attributes['document_file']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['document_file'], config('constants.SITE_AGENT_DOCUMENT_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $user->document()->updateOrCreate(['documentable_id' => $id], [
                        'title' => $attributes['title'],
                        'documentable_type ' => get_class($user),
                        'documentable_id ' => $user->id,
                        'document_type' => 'document',
                        'file' => $fileName,
                    ]);
                }
            }

        }
        return $user;
    }
    /**
     * Create an admin
     *
     * @param array $params
     * @return mixed
     */
    public function createAdmin(array $params)
    {
        $user = $this->create([
            'first_name' => $params['first_name'],
            'last_name' => $params['last_name'],
            'mobile_number' => $params['mobile_number'],
            'email' => $params['email'],
            'email_verified_at' => \Carbon\Carbon::now(),
            'password' => bcrypt($params['password']),
            'is_approve' => 1,
        ]);
        ## Admin role and permission
        if ($user) {
            $user->roles()->sync($params['role_id']);
            $user->profile()->create([
                'address' => $params['address'],
                'organization_name' => $params['organization_name'],
                'designation' => $params['designation'],
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
                        'is_profile_picture' => true,
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

            $mailParams = array();
            $mailParams['mail_type'] = 'seller_invite';
            $mailParams['to'] = $params['email'];
            $mailParams['password'] = $params['password'];
            $mailParams['from'] = config('mail.from.address');
            $mailParams['subject'] = $user->roles()->first()->name . ' Invitation from ' . env('APP_NAME');
            $mailParams['greetings'] = "Hello ! User";
            $mailParams['line'] = 'You have been invited to become an ' . $user->roles()->first()->name . ' at ' . env('APP_NAME');
            $mailParams['content'] = "Click on the button below to login as an " . $user->roles()->first()->name . ".";
            $mailParams['link'] = route('login');
            $mailParams['end_greetings'] = "Regards,";
            $mailParams['from_user'] = env('MAIL_FROM_NAME');
            Mail::send(new SendMailable($mailParams));
        }
        return $user;
    }

    public function updateStatus(array $attributes,$id)
    {
        if(isset($attributes['is_active'])){
            $attributes['is_approve']= $attributes['is_active'];
        }
        return $this->update($attributes, $id);
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
        return $this->find(auth()->user()->id)->addressBook()->create($attributes);
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

    /*ADMIN PART TEMP*/

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findUserByEmail($email)
    {
        try {
            return $this->model->where('email', '=', $email)->first();

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * Update user profile image
     *
     * @param array $params
     * @param int $id
     * @return bool
     */

    /**
     * Find an user by username
     *
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findUserByUsername($username)
    {
        try {
            return $this->model->where('username', '=', $username)->first();

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * Get all approves users by profile type
     *
     * @param $profileTypes
     * @return mixed
     */
    public function getApprovedUsersWithProfileType($profileTypes)
    {
        if (!is_array($profileTypes)) {
            $profileTypes = array($profileTypes);
        }

        return $this->model->whereIn('profile_type', $profileTypes)
            ->where('is_approve', true)
            ->get();
    }

    public function userUpdate(array $attributes, int $id)
    {
        $user = $this->find($id);
        $isUserUpdated = $this->update($attributes, $id);
        if ($isUserUpdated) {
            $user->profile()->update([
                'gender' => $attributes['gender'],
                'address' => $attributes['address'],
            ]);
            if (isset($attributes['profile_image'])) {
                $fileName = uniqid() . '.' . $attributes['profile_image']->getClientOriginalExtension();
                $isImageUploaded = $this->uploadOne($attributes['profile_image'], config('constants.SITE_PROFILE_IMAGE_UPLOAD_PATH'), $fileName);

                if ($isImageUploaded) {
                    $isFileRelatedMediaCreated = $user->media()->updateOrCreate(['is_profile_picture' => true, 'user_id' => auth()->user()->id], [
                        'user_id' => auth()->user()->id,
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $user->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true,
                    ]);
                }
            }
        }
        return $isUserUpdated;
    }

    public function updateDetails($attributes, $id)
    {
        $isUserUpdated = $this->update($attributes, $id);
        if ($isUserUpdated) {
            $user = $this->findDetails($id);
            if (isset($attributes['profile_image'])) {
                $fileName = uniqid() . '.' . $attributes['profile_image']->getClientOriginalExtension();
                $isUserRelatedMediaUploaded = $this->uploadOne($attributes['profile_image'], config('constants.SITE_USER_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isUserRelatedMediaUploaded) {
                    $user->media()->updateOrCreate(['user_id' => $id, 'is_profile_picture' => true], [
                        'user_id' => $id,
                        'mediaable_type' => get_class($user),
                        'mediaable_id' => $id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true,
                    ]);
                }

            }
            $user->profile()->updateOrCreate(['user_id' => $id], [
                'user_id' => $id,
                'gender' => $attributes['gender'],
                'address' => $attributes['address'],
            ]);
        }
        return $isUserUpdated;
    }

    public function updateSeller(array $attributes, int $id)
    {
        $userData = $this->find($id);
        $isSellerUpdated = $this->update($attributes, $id);

        if ($isSellerUpdated) {
            $userData->profile()->updateOrCreate(['user_id' => $userData->id], [
                'address' => $attributes['address'],
                'organization_name' => $attributes['organization_name'],
                'designation' => $attributes['designation'],
                'user_id' => $userData->id,
            ]);

            if (isset($attributes['seller_image'])) {
                $fileName = uniqid() . '.' . $attributes['seller_image']->getClientOriginalExtension();
                $isFileUploaded = $this->uploadOne($attributes['seller_image'], config('constants.SITE_ORIGINAL_IMAGE_UPLOAD_PATH'), $fileName, 'public');
                if ($isFileUploaded) {
                    $isFileRelatedMediaCreated = $userData->media()->updateOrCreate(['is_profile_picture' => true, 'user_id' => $userData->id], [
                        'user_id' => $userData->id,
                        'mediaable_type' => get_class($userData),
                        'mediaable_id' => $userData->id,
                        'media_type' => 'image',
                        'file' => $fileName,
                        'is_profile_picture' => true,
                    ]);
                }
            }

            if (isset($attributes['document'])) {
                // dd('here');
                foreach ($attributes['document'] as $document) {
                    $fileName = uniqid() . '.' . $document['file']->getClientOriginalExtension();
                    $title = $document['title'];
                    $isFileUploaded = $this->uploadOne($document['file'], config('constants.SITE_SELLER_DOCUMENT_UPLOAD_PATH'), $fileName, 'public');
                    if ($isFileUploaded) {
                        $isFileRelatedMediaCreated = $userData->document()->create([
                            'title' => $title,
                            'documentable_type ' => get_class($userData),
                            'documentable_id ' => $userData->id,
                            'document_type' => 'document',
                            'file' => $fileName,
                        ]);
                    }
                }
            }
        }
        return $isSellerUpdated;

    }

    public function findDocument($id)
    {
        return $this->documentModel->find($id);
    }

}

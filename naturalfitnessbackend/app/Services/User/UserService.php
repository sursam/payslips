<?php

namespace App\Services\User;


use Illuminate\Support\Facades\Hash;
use App\Contracts\Users\UserContract;
//use App\Contracts\Payment\PaymentContract;

class UserService
{
    /**
     * @var UserContract
     */
    protected $userRepository;
    /**
     * @var PaymentContract
     */
    //protected $paymentRepository;

	/**
     * UserService constructor
     */
    public function __construct(UserContract $userRepository){
        $this->userRepository    = $userRepository;
        //$this->paymentRepository = $paymentRepository;
    }

    public function getTotalUsers(string $role,$status = 'all',string $search=null){
        if($status!='all'){
            if(!is_null($search)){
                return $this->userRepository->findUserByRole(['is_active'=>$status],$role,'id','asc','','',false,$search)->count();
            }
            return $this->userRepository->findUserByRole(['is_active'=>$status],$role)->count();
        }
        if(!is_null($search)){
            return $this->userRepository->findUserByRole([],$role,'id','asc','','',false,$search)->count();
        }
        return $this->userRepository->findUserByRole([],$role)->count();
    }

    public function getTotalUsersByCondition(string $role,$filterConditions = [],$status = 'all', $limit = '',string $search=null){
        if($status!='all'){
            $filterConditions['is_active'] = $status;
            if(!is_null($search)){
                return $this->userRepository->findUserByRole($filterConditions,$role,'id','asc',$limit,'',false,$search)->count();
            }
            return $this->userRepository->findUserByRole($filterConditions,$role,'id','asc',$limit)->count();
        }
        if(!is_null($search)){
            return $this->userRepository->findUserByRole($filterConditions,$role,'id','asc',$limit,'',false,$search)->count();
        }

        return $this->userRepository->findUserByRole($filterConditions,$role,'id','asc',$limit)->count();
    }

    public function getTotalUsersByCategory(string $role,string $slug,$status = 'all',$search=null){
        return $this->userRepository->getUsersTotal($role,$slug,$status,$search);
    }

    public function findUserByRole(array $filterConditions,string $role,string $orderBy = 'id', string $sortBy = 'asc',$limit= null,$offset=null,$inRandomOrder=false,$search=null){

        return $this->userRepository->findUserByRole($filterConditions,$role,$orderBy,$sortBy,$limit,$offset,$inRandomOrder,$search);
    }
    public function findUserByRoleAndCategory(array $filterConditions,string $role,string $slug,string $orderBy = 'id', string $sortBy = 'asc',$limit= null,$offset=null,$inRandomOrder=false,$search=null){

        return $this->userRepository->findUserByRoleAndCategory($filterConditions,$role,$slug,$orderBy,$sortBy,$limit,$offset,$inRandomOrder,$search);
    }
    public function findUsersByCreatedBy(array $filterConditions,string $createdBy,string $orderBy = 'id', string $sortBy = 'asc',$limit= null,$offset=null,$inRandomOrder=false,$search=null){

        return $this->userRepository->findUsersByCreatedBy($filterConditions,$createdBy,$orderBy,$sortBy,$limit,$offset,$inRandomOrder,$search);
    }

    /**
     * Find user by id
     *
     * @param int $id
     * @return mixed
     */
    public function findUser(int $id)    {
        return $this->userRepository->find($id);
    }

    public function findUserBy(array $where)    {
        return $this->userRepository->findOneBy($where);
    }

    public function registerCustomer(array $attributes){
        return $this->userRepository->registerCustomer($attributes);
    }

     /**
     * Get user profile details
     *
     * @param int $userId
     * @return mixed
     */
    public function findUserProfile(int $userId)    {
        return $this->userRepository->with('profile')
            ->where('id', $userId)
            ->first();
    }

    /**
     * Fetch list of users by user ids
     *
     * @param array $userIds
     * @param array $columns
     * @return mixed
     */
    public function findUserByIds(array $userIds, array $columns){
        return $this->userRepository->findUserByIds($userIds, $columns);
    }

    /**
     * Find list of users based on certain condition
     *
     * @param $profileType
     * @param null $filterConditions
     * @param int $status
     * @param string $sortBy
     * @param null $limit
     * @return mixed
     */
    public function findUsers($profileType, $filterConditions = null,
        $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)    {
        return $this->userRepository->findUsers($profileType, $filterConditions, $orderBy, $sortBy, $limit, $inRandomOrder);
    }

    /**
     * Find list of users for frontend based on certain condition
     *
     * @param $profileType
     * @param null $filterConditions
     * @param int $status
     * @param string $sortBy
     * @param null $limit
     * @return mixed
     */
    public function userSearch($profileType, $filterConditions = null,
        $orderBy = 'id', $sortBy = 'asc', $limit = null, $inRandomOrder = false)    {
        return $this->userRepository->userSearch($profileType, $filterConditions, $orderBy, $sortBy, $limit, $inRandomOrder);
    }

    public function validatePassword(string $password, int $userId){
        $currentHashedPassword = $this->userRepository->find($userId)->password;
        return Hash::check($password, $currentHashedPassword);
    }

    public function saveUserProfileDetails($attributes,$userId){
        $attributes['password'] = Hash::make($attributes['password']);
        return $this->userRepository->update($attributes, $userId);
    }
    public function userDetailsUpdate(array $attributes, int $userId){
        return $this->userRepository->userUpdate($attributes, $userId);
    }

    public function findUserByUserName($userName)    {
        return $this->userRepository->findOneBy([
            'username' => $userName
        ]);
    }

    public function findUserByEmail($email){
        return $this->userRepository->findOneBy([
            'email' => $email
        ]);
    }

    public function findUserById($id){
        return $this->userRepository->findOneBy([
            'id' => $id
        ]);
    }
    public function findDeletedUserById($id){
        return $this->userRepository->findDeletedOneBy([
            'id' => $id
        ]);
    }

    /*ZM TESTED*/

    public function getAdmins(){
        return $this->userRepository->getUsers('admin');
    }

    public function getSellers()
    {
        return $this->userRepository->getUsers('seller');
    }
    public function getSellersDashboard($role,$filterConditions,$limit)
    {
        return $this->userRepository->getSellersDashboard($role,$filterConditions,$limit);
    }
    public function getCustomers($role)
    {
        return $this->userRepository->getUsers($role);
    }
    public function getCustomersDashboard($role,$filterConditions,$limit)
    {
        return $this->userRepository->getCustomersDashboard($role,$filterConditions,$limit);
    }

    public function getEmployees(string $role,string $type)
    {
        return $this->userRepository->getEmployeeUsers($role,$type);
    }

    public function getAllUsers($filterConditions,$role,string $orderBy = 'id', $sortBy = 'asc')
    {
        return $this->userRepository->getAllUsers($filterConditions,$role,$orderBy,$sortBy);
    }

    public function createOrUpdateCustomer($attributes,$id=null){
        if(!is_null($id)){
            return $this->userRepository->updateCustomer($attributes,$id);
        }
        return $this->userRepository->createCustomer($attributes);
    }
    public function createOrUpdateAgent($attributes,$id=null){
        if(!is_null($id)){
            return $this->userRepository->updateAgent($attributes,$id);
        }
        return $this->userRepository->createAgent($attributes);
    }


    /**
     * Create an admin
     *
     * @param array $params
     * @return mixed
     */
    public function createAdmin(array $params){
        return $this->userRepository->createAdmin($params);
    }


    public function findMultipleUserBy(array $params)    {
        return $this->userRepository->findBy($params);
    }


    public function listUsers()    {
        return $this->userRepository->listUsers();
    }


     /**
     * Update user profile image
     *
     * @param array $params
     * @param int $id
     * @return bool
     */
    public function updateProfileImage($uploadedFile, int $id)    {
        $updated = $this->userRepository->updateProfileImage($uploadedFile, $id);
        return ($updated);
    }

    public function findById($id)    {
        return $this->userRepository->find($id);
    }


    public function updateUserDetails($attributes,$id){
        return $this->userRepository->updateDetails($attributes,$id);
    }
    public function updateUserStatus(array $attributes,$id){
        return $this->userRepository->update($attributes,$id);
    }

    public function deleteUser($request){
      $id=uuidtoid($request['uuid'],'users');
      $user=$this->userRepository->find($id);
      $isUserDeleted= $user->delete($id);
      if($isUserDeleted){
        $user->profile()->delete();
      }
      return $isUserDeleted;
    }
    public function deleteDocument($id){
      $document=$this->userRepository->findDocument($id);
      return $document->delete($id);
    }

    public function updateSeller(array $attributes,int $id)    {
        return $this->userRepository->updateSeller($attributes, $id);
    }

    /* public function createSeller($request) {
        return $this->userRepository->createAdmin($request);
    } */

    public function findAddress($id){
        return $this->userRepository->findAddress($id);
    }
    public function createOrUpdateCustomerAddress($attributes,$id=null){
        if(!is_null($id)){
            return $this->userRepository->updateAddress($attributes,$id);
        }else{
            return $this->userRepository->createAddress($attributes);
        }

    }

    public function deleteAddress($id){
        return $this->userRepository->deleteAddress($id);
    }


    public function createOrUpdateCart(array $attributes){
        return $this->userRepository->createOrUpdateCart($attributes);
    }

    public function createUser(array $attributes){
        return $this->userRepository->createUser($attributes);
    }
    public function updateUser(array $attributes,int $id){
        return $this->userRepository->updateUser($attributes,$id);
    }
    public function createDriver(array $attributes,int $id){
        return $this->userRepository->createDriver($attributes,$id);
    }

    public function update(array $attributes,$id){
        return $this->userRepository->update($attributes,$id);
    }

    public function createCouncil(array $attributes){
        return $this->userRepository->createCouncil($attributes);
    }
    public function updateCouncil(array $attributes,int $id){
        return $this->userRepository->updateCouncil($attributes,$id);
    }
    public function createAgent(array $attributes){
        return $this->userRepository->createAgent($attributes);
    }
    public function updateAgent(array $attributes,int $id){
        return $this->userRepository->updateAgent($attributes,$id);
    }
    public function userSupportDetails(){
        return $this->userRepository->userSupportDetails();
    }

    public function addBrandingHistory($attributes){
        return $this->userRepository->addBrandingHistory($attributes);
    }

    public function getTotalDeletedUsersByCondition(string $role,$filterConditions = [],$status = 'all', $limit = '',string $search=null){
        if($status!='all'){
            $filterConditions['is_active'] = $status;
            if(!is_null($search)){
                return $this->userRepository->findDeletedUserByRole($filterConditions,$role,'id','asc',$limit,'',false,$search)->count();
            }
            return $this->userRepository->findDeletedUserByRole($filterConditions,$role,'id','asc',$limit)->count();
        }
        if(!is_null($search)){
            return $this->userRepository->findDeletedUserByRole($filterConditions,$role,'id','asc',$limit,'',false,$search)->count();
        }
        return $this->userRepository->findDeletedUserByRole($filterConditions,$role,'id','asc',$limit)->count();
    }
    public function findDeletedUserByRole(array $filterConditions,string $role,string $orderBy = 'id', string $sortBy = 'asc',$limit= null,$offset=null,$inRandomOrder=false,$search=null){

        return $this->userRepository->findDeletedUserByRole($filterConditions,$role,$orderBy,$sortBy,$limit,$offset,$inRandomOrder,$search);
    }

    public function getTotalReferrals(array $filterConditions,string $search=null){
        if(!is_null($search)){
            return $this->userRepository->findReferrals($filterConditions,'id','asc','','',false,$search)->count();
        }
        return $this->userRepository->findReferrals($filterConditions,'id','asc','','',false)->count();
    }
    public function findReferrals(array $filterConditions,string $orderBy = 'id', string $sortBy = 'asc',$limit= null,$offset=null,$inRandomOrder=false,$search=null){

        return $this->userRepository->findReferrals($filterConditions,$orderBy,$sortBy,$limit,$offset,$inRandomOrder,$search);
    }
    public function createOrUpdateReferral($attributes,$id=null){
        if(!is_null($id)){
            return $this->userRepository->updateReferral($attributes,$id);
        }
        return $this->userRepository->createReferral($attributes);
    }
    public function findReferralById($id){
        return $this->userRepository->findReferralById($id);
    }
}

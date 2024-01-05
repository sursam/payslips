<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\HasRolesAndPermissions as TraitsHasRolesAndPermissions;



class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, TraitsHasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $appends= [
        'profile_picture'
    ];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    protected $fillable = [
        'first_name',
        'last_name',
        'uuid',
        'email',
        'mobile_number',
        'verification_code',
        'password',
        'username',
        'email_verified_at',
        'is_active',
        'is_approve',
        'is_blocked',
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];




    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at'      => 'datetime',
        'two_factor_expires_at'  =>  'datetime',
        'notifications'          => 'array',
        'address'                => 'array',
    ];

    public function generateUserName($userType,$name){
        $number= mt_rand(100000,999999);
        $username= $userType.substr($name,3).$number;
        if($this->usernameexists($username)){
            return $this->generateUsername($userType,$name);
        }
        return $username;
    }
    public function generateTwoFactorCode(){
        $this->timestamps = false;
        $this->two_factor_code = rand(10000, 99999);
        $this->two_factor_expires_at = now()->addMinutes(2);
        $this->save();
    }

    public function resetTwoFactorCode(){
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    public function profile(){
        return $this->hasOne(Profile::class);
    }
    public function Wishlists(){
        return $this->hasMany(Wishlist::class);
    }
    public function device(){
        return $this->hasMany(Device::class);
    }

    public function deliveries(){
        return $this->hasMany(DeliveryStatus::class);
    }

    public function getProfilePictureAttribute() {
        return $this->profilePicture();
    }
    public function getCustomerPictureAttribute() {
        return $this->profilePicture('original/user');
    }

    public function getFullNameAttribute() {
        return $this->first_name .(!is_null($this->last_name) ?  ' ' . $this->last_name : '');
    }
    public function profilePicture($type = 'profile') {
        $profilePicture = $this->media()->where('is_profile_picture', 1)->value('file');
        // return $profilePicture;
        if(!is_null($profilePicture)){
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if($fileDisk == 'public'){
                if(file_exists(public_path('storage/images/' . $type . '/' . $profilePicture))){
                    return asset('storage/images/' . $type . '/' . $profilePicture);
                }
            }
        }
        return asset('assets/images/dummy-user.png');
    }

    public function media(){
        return $this->hasMany(Media::class, 'user_id', 'id');
    }

    public function document(){
        return $this->morphMany(Document::class,'documentable');
    }
    public function getLicenceApprovedAttribute(){
        $license = $this->document->where('title','Driving Licence')->where('status',true)?->first();
        return (bool)$license ?? false;
    }
    public function getDrivingLicenseAttribute(){
        $license = $this->document->where('title','Driving Licence')?->first()->file;
        if($license){
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if($fileDisk == 'public'){
                if(file_exists(public_path('storage/images/documents/agent/' . $license))){
                    return asset('storage/images/documents/agent/' . $license);
                }
            }
        }
        return asset('assets/images/dummy-user.png');
    }

    public function scopeActive($query,$type){
        return $query->whereHas(
            'roles', function($q) use ($type){
                $q->where('slug', $type);
            })->where('is_active','1');
    }

    public function scopeInactive($query,$type){
        return $query->whereHas(
            'roles', function($q) use ($type){
                $q->where('slug', $type);
            })->where('is_active','0');
    }

    public function scopeUsernameexists($query,$username){
        return $query->where('username',$username)->exists();
    }

    public function addressBook(){
        return $this->hasMany(Address::class);
    }

    public function productReviews(){
        return $this->hasMany(Review::class);
    }

    public function feedbackReviews(){
        return $this->morphMany(Review::class, 'reviewable');
    }
    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function coupons(){
        return $this->belongsToMany(Coupon::class,'users_coupons');
    }

    public function earnings(){
        return $this->hasMany(Earning::class,'agent_id');
    }
    public function tips(){
        return $this->hasMany(Earning::class,'customer_id');
    }

    public function getTotalEarningAttribute(){
        return $this->earnings->where('is_approve',true)->sum('amount');
    }

    public function account(){
        return $this->hasOne(BankDetails::class);
    }

}

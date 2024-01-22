<?php

namespace App\Models\User;

use App\Models\Booking\Booking;
use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use App\Models\Site\Media;
use App\Models\Cms\Support;
use App\Models\User\Wallet;
use App\Models\Vehicle\Vehicle;
use App\Models\Site\Transaction;
use Laravel\Passport\HasApiTokens;
use App\Models\Site\BrandingHistory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use TaylorNetwork\UsernameGenerator\GeneratesUsernames;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use TaylorNetwork\UsernameGenerator\FindSimilarUsernames;
use App\Traits\HasRolesAndPermissions as TraitsHasRolesAndPermissions;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens,HasFactory,Notifiable,SoftDeletes;
    use GeneratesUsernames,FindSimilarUsernames,TraitsHasRolesAndPermissions;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
        self::softDeleted(function ($model) {
            $model->profile->delete();
        });

        self::softDeleted(function ($model) {
            $model->email= $model->email.'--'.time();
            $model->update();
        });
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $appends= [
        'profile_picture'
    ];
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'username',
        'mobile_number',
        'password',
        'is_active',
        'is_approve',
        'is_branding',
        'verification_code',
        'created_by',
        'registration_step',
        'fcm_token',
        'is_registered',
        'is_online',
        'last_login_at',
        'last_logout_at',
        'mobile_number_verified_at'
    ];



    public function transactions():MorphMany{
        return $this->morphMany(Transaction::class,'transactionable');
    }

    protected $guarded = ['id'];

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
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

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
    public function vehicle():HasOne{
        return $this->hasOne(Vehicle::class);
    }

    public function wallet():HasOne{
        return $this->hasOne(Wallet::class);
    }

    public function Wishlists(){
        return $this->hasMany(Wishlist::class);
    }

    public function devices(){
        return $this->hasMany(Device::class);
    }

    public function media(){
        return $this->hasMany(Media::class, 'user_id', 'id');
    }

    public function image():MorphMany{
        return $this->morphMany(Media::class,'mediaable');
    }
    public function getProfilePictureAttribute() {
        return $this->profilePicture('original');
    }

    public function addresses(){
        return $this->hasMany(Address::class);
    }

    public function productReviews(){
        return $this->hasMany(Review::class);
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function purchaseOrders():HasMany{
        return $this->hasMany(PurchaseOrder::class);
    }

    public function support(){
        return $this->hasMany(Support::class);
    }


    public function getFullNameAttribute() {
        return $this->first_name .(!is_null($this->last_name) ?  ' ' . $this->last_name : '');
    }


    public function profilePicture($type = 'original') {
        $profilePicture = $this->media()->where('is_profile_picture', 1)->value('file');

        //dd($profilePicture);
        if(!is_null($profilePicture)){
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if($fileDisk == 'public' && file_exists(public_path('storage/images/' . $type . '/user/' . $profilePicture))){
                return asset('storage/images/' . $type . '/user/' . $profilePicture);

            }
        }
        if(auth()->user() && auth()->user()->profile->gender== 'female') return asset('assets/frontend/images/dummy-user-girl.png');
        return asset('assets/images/user.png');
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

    public function roles():BelongsToMany {
        return $this->belongsToMany(Role::class,'users_roles');
    }

    public function getUserDocumentAttribute($mediaType) {
        return $this->userDocument($mediaType, 'original');
    }
    public function userDocument($mediaType, $type = 'original') {
        $userDocument = $this->media()->where('media_type', $mediaType)->value('file');

        if(!is_null($userDocument)){
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if($fileDisk == 'public' && file_exists(public_path('storage/images/' . $type . '/user/' . $userDocument))){
                return asset('storage/images/' . $type . '/user/' . $userDocument);

            }
        }
        return asset('assets/images/no-image.png');
    }
    public function mediaStatus($mediaType) {
        return $this->media()->where('media_type', $mediaType)->value('is_approve');
    }
    public function brandingHistories(){
        return $this->hasMany(BrandingHistory::class, 'sender_id');
    }

    /*public function isOnline()
    {
        return cache()->has('user-online' . $this->id);
    }*/

    public function availabilities():HasMany{
        return $this->hasMany(DoctorsAvailability::class, 'doctor_id');
    }
    public function getTodaysAvailabilitiesAttribute(){
        return $this->availabilities->where('available_day', date ('l'));
    }
    public function availabilitiesByDay($day, $slot = ''){
        $availabilities = $this->availabilities->where('available_day', $day)->where('available_from', '<>', null);
        if($slot){
            $slotTime = Carbon::parse($slot)->format('H:i:s');
            $availabilities = $availabilities->where('available_from', '<=', $slotTime)
            ->where('available_to', '>=', $slotTime);
        }
        return $availabilities;
    }
    public function bookedDateTimes():HasMany{
        return $this->hasMany(Booking::class, 'doctor_id');
    }
    public function bookedTimesByDate($date){
        $bookedDates = $this->bookedDateTimes()
            ->whereDate('booking_datetime', $date)
            ->where('status', 1)
            ->pluck('booking_datetime')->toArray();
        return $bookedDates;
    }
}

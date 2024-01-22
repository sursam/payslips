<?php

namespace App\Models\Vehicle;

use Webpatser\Uuid\Uuid;
use App\Models\Site\Media;
use App\Models\Site\Category;
use App\Models\User\User;
use App\Models\Company\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'uuid',
        'registration_number',
        'company_id',
        'category_id',
        'sub_category_id',
        'body_type_id',
        'user_id',
        'helper_count',
        'status'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    public function users() {
        return $this->belongsTo(User::class);
    }
    public function vehicleType():BelongsTo{
        return $this->belongsTo(Category::class,'category_id');
    }
    public function vehicleSubType():BelongsTo{
        return $this->belongsTo(Category::class, 'sub_category_id');
    }
    public function vehicleBodyType():BelongsTo{
        return $this->belongsTo(Category::class,'body_type_id');
    }
    public function vehicleCompany():BelongsTo{
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function documents():MorphMany{
        return $this->morphMany(Document::class,'documentable');
    }
    public function media(){
        return $this->hasMany(Media::class, 'mediaable_id', 'id');
    }
    public function image():MorphMany{
        return $this->morphMany(Media::class,'mediaable');
    }
    public function getDisplayImageAttribute(){
        return $this->displayImage('original');
    }
    protected function displayImage($type='original'){
        $file= $this->image()->first()?->file;
        if($file){
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if($fileDisk == 'public'){
                if(file_exists(public_path('storage/images/' . $type . '/vehicle/' . $file))){
                    return asset('storage/images/' . $type . '/vehicle/' . $file);
                }
            }
        }
        return asset('assets/images/no-image.png');
    }

   
    public function getVehicleDocumentAttribute($mediaType) {
        return $this->vehicleDocument($mediaType);
    } 
    public function vehicleDocument($mediaType, $type = 'original') {

        $vehicleDocument = $this->media()->where('media_type', $mediaType)->value('file');
        // dd ($vehicleDocument);
        if(!is_null($vehicleDocument)){
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if($fileDisk == 'public' && file_exists(public_path('storage/images/' . $type . '/vehicle/' . $vehicleDocument))){
                return asset('storage/images/' . $type . '/vehicle/' . $vehicleDocument);

            }
        }
        return asset('assets/images/no-image.png');
    }
}

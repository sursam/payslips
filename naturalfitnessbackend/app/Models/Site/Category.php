<?php

namespace App\Models\Site;

use Webpatser\Uuid\Uuid;
use App\Models\Fare\Fare;
use App\Models\User\User;
use App\Models\Vehicle\Vehicle;
use App\Models\Cms\Support;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends Model
{
    use HasFactory,Sluggable,HasRecursiveRelationships,SoftDeletes;

    protected $fillable= [
        'name',
        'slug',
        'image',
        'type',
        'parent_id',
        'description',
        'is_active'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function parent(){
        return $this->belongsTo(static::class,'parent_id','id');
    }

    public function children() {
        return $this->hasMany(static::class,'parent_id','id');
    }

    public function groups():BelongsToMany{
        return $this->belongsToMany(Group::class,'category_group');
    }

    public function buildCategoryTreeHtml($categories)
    {
        $options = '';
        if(count($categories)){
            foreach($categories as $category) {
                $options .= '<option value="'.$category->id.'">'.$category->name.'</option>';
                if(!empty($category->children)){
                    $options .= $this->buildCategoryTreeHtml($category->children);
                }
            }
        }
        return $options;
    }

    public function image():MorphMany{
        return $this->morphMany(Media::class,'mediaable');
    }

    public function getDisplayImageAttribute(){
        return $this->categoryImage('original');
    }

    public function latestImage(){
        return $this->morphOne(Media::class, 'mediaable');
    }

    protected function categoryImage($type='original'){
        $file= $this->image()->first()?->file;
        if($file){
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if($fileDisk == 'public'){
                //dd(public_path('storage/images/' . $type . '/category/' . $file));
                if(file_exists(public_path('storage/images/' . $type . '/category/' . $file))){
                    return asset('storage/images/' . $type . '/category/' . $file);
                }
            }
        }
        return asset('assets/images/no-image.png');
    }

    public function attributes():BelongsToMany{
        return $this->belongsToMany(Attribute::class,'category_attribute');
    }

    public function questions() {
        return $this->belongsToMany(Question::class,'questions_categories');
    }

    public function fare():HasMany
    {
        return $this->hasMany(Category::class);
    }
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function subCategory()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    public function vehilcleSubTypes()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->where('type', '=', 'vehicle');
    }
    public function vehilcleBodyTypes()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->where('type', '=', 'vehicle_body');
    }
    public function fares() {
        return $this->hasMany(Fare::class);
    }
    public function faqs():HasMany
    {
        return $this->hasMany(Faq::class);
    }
    public function supports():HasMany
    {
        return $this->hasMany(Support::class);
    }
    public function vehicles():HasMany
    {
        return $this->hasMany(Vehicle::class);
    }
    
}

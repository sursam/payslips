<?php

namespace App\Models;

use App\Models\ProductAttribute;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Product extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $fillable = [
        'name',
        'uuid',
        'title',
        'slug',
        'tags',
        'description',
        'category_id',
        'brand_id',
        'vendor_id',
        'price',
        'discount',
        'is_featured',
        'is_top',
        'is_active',
        'created_by',
        'updated_by',
    ];
    protected $casts = [
        'tags' => 'array',
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
                'source' => 'name',
            ],
        ];
    }
    protected $appends = [
        'discounted_price',
        // 'latest_image'
    ];

    public function getdiscountedPriceAttribute()
    {
        return $this->discountedPrice();
    }

    public function discountedPrice()
    {
        return $this->price - ($this->price * ($this->discount / 100));
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function media()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }
    public function singleMedia()
    {
        return $this->morphOne(Media::class, 'mediaable');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function productAttribute()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id', 'id');
    }
    public function getLatestImageAttribute():string
    {
        $file= $this->media()->where(['is_featured'=>true])->get()->first()?->file;
        if (!$file){
            $file = $this->media->first()?->file;
        }
        // logger('product:'.$file);
        if (isset($file)) {
            return asset('storage/images/original/product/'. $file);
        }
        return asset('assets/admin/images/applications-image-21.jpg');
    }
    public function getProductImagesAttribute()
    {
        $files = $this->media?->sortByDesc('is_featured')->pluck('file','uuid');
        if ($files->isNotEmpty()) {
            foreach ($files as $key=>$file) {
                $pictures[$key] = asset('storage/images/original/product/' . $file);
            }
            return $pictures;
        }
        return array(asset('assets/admin/images/applications-image-21.jpg'));
    }
    public function getAllProductImagesAttribute()
    {
        $files = $this->media;
        if ($files->isNotEmpty()) {
            foreach ($files as $file) {
                $pictures[$file->uuid] = [
                    'product'=>$file->mediaable->id,
                    'file'=>asset('storage/images/original/product/' . $file->file),
                    'featured'=> $file->is_featured
                ];
            }
            return $pictures;
        }
        return array(['file'=>asset('assets/admin/images/applications-image-21.jpg')]);
    }

    public function getSpecificationsAttribute()
    {
        $specifications = $this->productAttribute;
        if ($specifications->isNotEmpty()) {
            foreach ($specifications as $key => $specification) {
                $data[$specification->attribute->name][$key]['value'] = $specification->value;
                $data[$specification->attribute->name][$key]['id'] = $specification->id;
                $data[$specification->attribute->name][$key]['price'] = $specification->attribute_price;
            }
            return $data;
        }
        return array();
    }
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function getAverageRatingAttribute(){
        $averageRating=0;
        $reviews= $this->reviews()->get();
        if($reviews->isNotEmpty()){
            $averageRating= $reviews->sum('overall_rating')/$reviews->count();
        }
        return $averageRating;
    }
}

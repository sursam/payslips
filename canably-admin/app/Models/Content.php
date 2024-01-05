<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Content extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $fillable = [
        'title',
        'sub_title',
        'uuid',
        'description',
        'link_text',
        'link',
        'section'
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

    public function media()
    {
        return $this->morphOne(Media::class, 'mediaable');
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    public function image($type)
    {
        $file = $this->media?->file;
        if ($file) {
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if ($fileDisk == 'public') {
                if (file_exists(public_path('storage/images/' . $type . '/content/' . $file))) {
                    return asset('storage/images/' . $type . '/content/' . $file);
                }
            }
        }
        return asset('assets/admin/images/logo.png');
    }

    public function getDisplayImageAttribute()
    {
        return $this->image('original');
    }
}

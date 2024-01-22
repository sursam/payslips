<?php

namespace App\Models\Cms;

use App\Models\Site\Seo;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Page extends Model
{
    use HasFactory,Sluggable,SoftDeletes;
    protected $table= 'pages';
    protected $guarded = [];
    public static function boot()    {
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

    public function seo():MorphOne{
        return $this->morphOne(Seo::class, 'seoable');
    }
}

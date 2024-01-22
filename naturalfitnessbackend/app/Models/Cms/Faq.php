<?php

namespace App\Models\Cms;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory, SoftDeletes;
    protected $table= 'faqs';
    protected $guarded = [];
    public static function boot()    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    public function seo():MorphOne{
        return $this->morphOne(Seo::class, 'seoable');
    }
    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}

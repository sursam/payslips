<?php

namespace App\Models\Cms;

use Webpatser\Uuid\Uuid;
use App\Models\User\User;
use App\Models\Site\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Support extends Model
{
    use HasFactory, SoftDeletes;
    protected $table= 'supports';
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
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function supportAnswer():HasMany
    {
        return $this->hasMany(SupportAnswer::class);
    }
}

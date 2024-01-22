<?php

namespace App\Models\Cms;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportAnswer extends Model
{
    use HasFactory, SoftDeletes;
    protected $table= 'support_answers';
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
    public function support():BelongsTo
    {
        return $this->belongsTo(Support::class);
    }
    public function parentSupportAnswer()
    {
        return $this->belongsTo(SupportAnswer::class, 'parent_id', 'id');
    }

    public function subSupportAnswer()
    {
        return $this->hasMany(SupportAnswer::class, 'parent_id', 'id');
    }
}

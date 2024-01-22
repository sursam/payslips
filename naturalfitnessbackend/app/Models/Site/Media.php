<?php

namespace App\Models\Site;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    use HasFactory,SoftDeletes;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function mediaable():MorphTo{
        return $this->morphTo();
    }

    protected $fillable=[
        'uuid',
        'user_id',
        'mediaable_type',
        'mediaable_id',
        'media_type',
        'file',
        'alt_text',
        'is_profile_picture',
        'meta_details',
        'is_approve'
    ];

    protected $casts= [
        'meta_details'=> array()
    ];
}

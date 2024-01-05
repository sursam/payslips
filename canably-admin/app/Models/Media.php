<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory,SoftDeletes;
    protected $table= 'medias';

    protected $fillable=[
        'uuid',
        'user_id',
        'mediaable_type',
        'mediaable_id',
        'media_type',
        'file',
        'is_featured',
        'alt_text',
        'is_profile_picture',
        'meta_details'
    ];

    protected $casts= [
        'meta_details'=> 'array'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function mediaable(){
        return $this->morphTo();
    }
}

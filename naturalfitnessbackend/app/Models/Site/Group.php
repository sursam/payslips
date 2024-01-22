<?php

namespace App\Models\Site;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    use HasFactory,SoftDeletes;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
            $model->name = 'Group-'.random_int(1,10000);
        });
        self::softDeleted(function ($model) {
            $model->details()->delete();
            $model->categories()->detach();
        });
    }

    protected $fillable = [
        'uuid',
        'name',
        'is_active'
    ];

    public function details():HasMany{
        return $this->hasMany(GroupDetail::class);
    }

    public function categories():BelongsToMany{
        return $this->belongsToMany(Category::class,'category_group');
    }

    public function faqs():HasMany{
        return $this->hasMany(Faq::class,'category_id');
    }
}

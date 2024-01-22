<?php

namespace App\Models\Company;

use App\Models\Site\Document;
use App\Models\Site\Media;
use App\Models\User\User;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Company extends Model
{
    use HasFactory,SoftDeletes;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
        self::softDeleted(function ($model) {
            $model()->medias()->delete();
            $model()->services()->delete();
            $model()->documents()->delete();
        });
    }

    protected $fillable = [
        'uuid',
        'name',
        'user_id',
        'document',
        'registration_number',
        'company_name',
        'business_name',
        'trading_address',
        'registered_address',
        'website',
        'ownership',
        'trade_started_at',
        'turnover',
        'employeees',
        'vat_no',
        'is_active',
        'is_registered',
    ];

    protected $casts = [
        'trade_started_at' =>'datetime'
    ];

    public function services():HasMany{
        return $this->hasMany(Service::class);
    }
    public function users() {
        return $this->belongsTo(User::class);
    }
    public function locations():HasOne{
        return $this->hasOne(Location::class);
    }

    public function medias():MorphMany{
        return $this->morphMany(Media::class,'mediaable');
    }
    public function documents():MorphMany{
        return $this->morphMany(Document::class,'documentable');
    }
}

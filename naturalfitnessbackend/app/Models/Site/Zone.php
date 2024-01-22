<?php

namespace App\Models\Site;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Zone extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];
    protected $fillable = [
        'uuid',
        'name',
        'description',
        'is_active'
    ];
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
        self::deleting(function ($query) {
            $query->ZonePostcodes()->delete();
        });
    }
    public function ZonePostcodes(): HasMany
    {
        return $this->hasMany(ZonePostcode::class,'zone_id');
    }
}

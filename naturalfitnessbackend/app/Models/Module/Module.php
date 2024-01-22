<?php

namespace App\Models\Module;

use Webpatser\Uuid\Uuid;
use App\Models\Module\ModuleField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    use HasFactory, SoftDeletes;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
        self::deleting(function ($query) {
            $query->moduleField()->delete();
        });
    }
    protected $guarded = [];

    public function moduleField(): HasMany
    {
        return $this->hasMany(ModuleField::class);
    }
}

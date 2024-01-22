<?php

namespace App\Models\Module;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module\ModuleFieldOption;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModuleField extends Model
{
    use HasFactory, SoftDeletes;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
        self::deleting(function ($query) {
            $query->moduleFieldOption()->delete();
        });
    }
    protected $guarded = [];

    public function module() {
        return $this->belongsTo(Module::class);
    } 
    public function moduleFieldOption(): HasMany
    {
        return $this->hasMany(ModuleFieldOption::class);
    }
}

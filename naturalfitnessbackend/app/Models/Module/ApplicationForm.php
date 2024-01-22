<?php

namespace App\Models\Module;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module\ApplicationFormOption;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationForm extends Model
{
    use HasFactory, SoftDeletes;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });

        self::deleting(function ($query) {
            $query->ApplicationFormOption()->delete();
        });
    }
    protected $guarded = [];

    public function ApplicationFormOption(): HasMany
    {
        return $this->hasMany(ApplicationFormOption::class,'application_form_id');
    }
}

<?php

namespace App\Models\Module;

use Webpatser\Uuid\Uuid;
use App\Models\Module\ApplicationForm;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module\ApplicationFormOption;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationUserInput extends Model
{
    use HasFactory, SoftDeletes;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    protected $guarded = [];

    public function application_form_options()
    {
        return $this->belongsTo(ApplicationFormOption::class, 'option_id', 'id');
    }
    public function applicationForm()
    {
        return $this->belongsTo(ApplicationForm::class);
    }
}

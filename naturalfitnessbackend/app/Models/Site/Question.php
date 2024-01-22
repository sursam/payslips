<?php

namespace App\Models\Site;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Medical\Issue;

class Question extends Model
{
    use HasFactory,SoftDeletes;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
        self::softDeleted(function ($model) {
            $model->answers()->delete();
        });
    }

    protected $fillable = [
        'uuid',
        'name',
        'issue_id',
        'type',
        'is_active'
    ];

    public function answers():HasMany{
        return $this->hasMany(Answer::class);
    }
    public function issues():BelongsToMany{
        return $this->belongsToMany(Issue::class, 'questions_issues');
    }
    public function getIssueListsAttribute(){
        return $this->issues->implode('name', ', ');
    }
    public function options():HasMany{
        return $this->hasMany(QuestionOption::class);
    }

}

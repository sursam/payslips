<?php

namespace App\Models\User;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory,Sluggable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable =[
        'name'
    ];

    public function roles():BelongsToMany {
        return $this->belongsToMany(Role::class,'roles_permissions');
    }

    public function scopeNotDashboard($query){
        return $query->whereNotIn('slug', ['view-dashboard','view-delivery','edit-delivery']);
    }
}

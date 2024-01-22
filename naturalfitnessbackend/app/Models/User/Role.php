<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
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

    protected $fillable= [
        'name',
        'slug'
    ];

    public function permissions() {
        return $this->belongsToMany(Permission::class,'roles_permissions');
    }


    public function getAllPermissions(array $permissions){
        return Permission::whereIn('slug',$permissions)->get();
    }

    public function hasPermission($permission){
        return (bool) $this->permissions->where('slug', $permission)->count();
    }

    public function givePermissionsTo($permissions){
        // dd($permissions);
        $permissions = $this->getAllPermissions($permissions);
        if($permissions === null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }
}

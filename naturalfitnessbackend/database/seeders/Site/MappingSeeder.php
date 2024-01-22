<?php

namespace Database\Seeders\Site;

use App\Models\User\Role;
use App\Models\User\User;
use App\Models\User\Permission;
use Illuminate\Database\Seeder;

class MappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminUser = User::find(1);
        $isSuperAdminRole = Role::where('slug', 'super-admin')->first();
        $permissions = Permission::get();
        /* Assign permission to the role */
        $isSuperAdminRole->permissions()->sync($permissions);
        /* Assign role and permission to the user */
        $superAdminUser->roles()->sync($isSuperAdminRole);
        $superAdminUser->permissions()->sync($permissions);
    }
}

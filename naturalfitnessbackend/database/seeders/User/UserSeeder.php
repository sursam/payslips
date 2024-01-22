<?php

namespace Database\Seeders\User;

use App\Models\User\User;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Request $request): void
    {
        $faker = Faker::create();
        $adminUser = new User();
        $adminUser->uuid = $faker->uuid;
        $adminUser->first_name = 'Super';
        $adminUser->last_name = 'Admin';
        $adminUser->username = 'superadmin';
        $adminUser->email = 'super.admin@naturalfitness.com';
        $adminUser->mobile_number = 9876543210;
        $adminUser->email_verified_at = $faker->dateTime();
        $adminUser->mobile_number_verified_at = $faker->dateTime();
        $adminUser->password = bcrypt('secret');
        $adminUser->registration_ip = $request->getClientIp();
        $adminUser->is_active = 1;
        if($adminUser->save()){
            $adminUser->profile()->create([
                'uuid'=>$faker->uuid,
                'gender'=> 'male',
            ]);
        }
    }
}

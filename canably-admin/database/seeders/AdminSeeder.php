<?php
namespace Database\Seeders;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Database\Seeder;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Request $request)
    {
        $faker = Faker::create();
        $isAdminRole = Role::where('slug', 'super-admin')->first();
        $permissions= Permission::get();
        $user = new User();
        $user->uuid = $faker->uuid;
        $user->first_name = 'Super';
        $user->last_name = 'Admin';
        $user->username = 'superadmin';
        $user->email = 'super.admin@canably.com';
        $user->mobile_number = 9191244321;
        $user->email_verified_at = $faker->dateTime();
        $user->mobile_number_verified_at = $faker->dateTime();
        $user->password = bcrypt('secret');
        $user->registration_ip = $request->getClientIp();
        $user->is_active = 1;
        if($user->save()){
            $user->profile()->create([
                'uuid'=>$faker->uuid,
                'birthday'=>'1993-05-27',
                'gender'=> 'male',
            ]);
        }
        $user->roles()->attach($isAdminRole);
        $permissions= Permission::get();
        $user->permissions()->attach($permissions);
        $isSellerRole = Role::where('slug', 'seller')->first();
        $seller = new User();
        $seller->uuid = $faker->uuid;
        $seller->first_name = 'Canably';
        $seller->last_name = 'Vendor';
        $seller->username = 'adminseller';
        $seller->email = 'seller.admin@canably.com';
        $seller->mobile_number = 9193344321;
        $seller->email_verified_at = $faker->dateTime();
        $seller->mobile_number_verified_at = $faker->dateTime();
        $seller->password = bcrypt('secret');
        $seller->registration_ip = $request->getClientIp();
        $seller->is_active = 1;
        if($seller->save()){
            $seller->profile()->create([
                'uuid'=>$faker->uuid,
                'organization_name'=>'Canably',
                'designation'=>'Admin Seller',
                'birthday'=>'1992-05-27',
                'gender'=> 'male',
            ]);
        }
        $seller->roles()->attach($isSellerRole);
        $isAgentRole = Role::where('slug', 'delivery-agent')->first();
        $agent = new User();
        $agent->uuid = $faker->uuid;
        $agent->first_name = 'Canably';
        $agent->last_name = 'Agent';
        $agent->username = 'TesterAgent';
        $agent->email = 'testeragent@canably.com';
        $agent->mobile_number = 1234567890;
        $agent->email_verified_at = $faker->dateTime();
        $agent->mobile_number_verified_at = $faker->dateTime();
        $agent->password = bcrypt('secret');
        $agent->registration_ip = $request->getClientIp();
        $agent->is_active = 1;
        if($agent->save()){
            $agent->profile()->create([
                'uuid'=>$faker->uuid,
                'birthday'=>'1990-01-27',
                'gender'=> 'male',
            ]);
        }
        $agent->roles()->attach($isAgentRole);

        $isCustomerRole = Role::where('slug', 'customer')->first();
        $customer = new User();
        $customer->uuid = $faker->uuid;
        $customer->first_name = 'Canably';
        $customer->last_name = 'Customer';
        $customer->username = 'TesterCustomer';
        $customer->email = 'testercustomer@canably.com';
        $customer->mobile_number = 1234657890;
        $customer->email_verified_at = $faker->dateTime();
        $customer->mobile_number_verified_at = $faker->dateTime();
        $customer->password = bcrypt('secret');
        $customer->registration_ip = $request->getClientIp();
        $customer->is_active = 1;
        if($customer->save()){
            $customer->profile()->create([
                'uuid'=>$faker->uuid,
                'birthday'=>'1993-05-27',
                'gender'=> 'male',
            ]);
            $customer->addressBook()->create([
                'name' => 'Tester Customer',
                'phone_number' => '1234567890',
                'full_address'=> [
                    "address_line_one"=>"C\/26 R.K Uponibesh",
                    "address_line_two"=>'',
                    "city"=>"Kolkata",
                    "state"=>"West Bengal",
                    "country"=>"India"
                ],
                'zip_code'=> 700092,
                'type' => 'office',
                'is_default' => true,
                'created_by'=>$customer->id,
                'updated_by'=>$customer->id
            ]);
        }
        $customer->roles()->attach($isCustomerRole);
    }
}

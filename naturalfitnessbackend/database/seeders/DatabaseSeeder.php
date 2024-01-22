<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Cms\PageSeeder;
use Database\Seeders\Site\CategorySeeder;
use Database\Seeders\User\RoleSeeder;
use Database\Seeders\User\UserSeeder;
use Database\Seeders\Site\StatesSeeder;
use Database\Seeders\Site\MappingSeeder;
use Database\Seeders\Site\CountriesSeeder;
use Database\Seeders\Site\FaqSeeder;
use Database\Seeders\User\PermissionSeeder;
use Database\Seeders\Site\PaymentModeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MappingSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(StatesSeeder::class);
        $this->call(PageSeeder::class);
        //$this->call(CategorySeeder::class);
        $this->call(PaymentModeSeeder::class);
        $this->call(FaqSeeder::class);

    }
}

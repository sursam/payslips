<?php

namespace Database\Seeders\Site;

use App\Models\Site\PaymentMode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json  = file_get_contents(database_path().'/data/payment-modes.json');
        $data  = json_decode($json);
        foreach ($data->modes as $key => $value) {
            PaymentMode::updateOrCreate([
                'name'=> $value->name,
            ]);
        }
    }
}

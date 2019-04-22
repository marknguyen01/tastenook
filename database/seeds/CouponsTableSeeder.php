<?php

use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::create([
            'name' => '20% of on any burger',
            'description' => 'Applied to only one burger per order per person',
            'code' => '20BURGER',
            'expired_at' => '2019-05-31',
            'business_id' => 1,
            'user_id' => 1,
        ]);
    }
}

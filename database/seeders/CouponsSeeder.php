<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = [
            [
                'instructor_id' => 1,
                'offer_name' => 'Summer Sale',
                'code' => 'SUMMER20',
                'type' => 'percentage',
                'amount' => 20,
                'quantity' => 100,
                'redemptions' => 0,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'instructor_id' => 1,
                'offer_name' => 'New User Discount',
                'code' => 'WELCOME10',
                'type' => 'percentage',
                'amount' => 10,
                'quantity' => 200,
                'redemptions' => 45,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'instructor_id' => 1,
                'offer_name' => 'Flash Sale',
                'code' => 'FLASH50',
                'type' => 'fixed_amount',
                'amount' => 50,
                'quantity' => 50,
                'redemptions' => 12,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'instructor_id' => 2,
                'offer_name' => 'Early Bird',
                'code' => 'EARLYBIRD25',
                'type' => 'percentage',
                'amount' => 25,
                'quantity' => 0,
                'redemptions' => 87,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'instructor_id' => 2,
                'offer_name' => 'Weekend Special',
                'code' => 'WEEKEND15',
                'type' => 'percentage',
                'amount' => 15,
                'quantity' => 150,
                'redemptions' => 32,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'instructor_id' => 3,
                'offer_name' => 'Holiday Discount',
                'code' => 'HOLIDAY30',
                'type' => 'percentage',
                'amount' => 30,
                'quantity' => 300,
                'redemptions' => 210,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'instructor_id' => 4,
                'offer_name' => 'Fixed Amount Off',
                'code' => 'SAVE20',
                'type' => 'fixed_amount',
                'amount' => 20,
                'quantity' => 100,
                'redemptions' => 65,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'instructor_id' => 4,
                'offer_name' => 'Upcoming Promotion',
                'code' => 'FUTURE10',
                'type' => 'percentage',
                'amount' => 10,
                'quantity' => 500,
                'redemptions' => 0,
                'status' => 'scheduled',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'instructor_id' => 5,
                'offer_name' => 'Expired Coupon',
                'code' => 'OLD15',
                'type' => 'percentage',
                'amount' => 15,
                'quantity' => 100,
                'redemptions' => 100,
                'status' => 'expired',
                'created_at' => Carbon::now()->subMonths(3),
                'updated_at' => Carbon::now()->subMonths(1)
            ],
            [
                'instructor_id' => 5,
                'offer_name' => 'Draft Coupon',
                'code' => 'DRAFT99',
                'type' => 'percentage',
                'amount' => 99,
                'quantity' => 10,
                'redemptions' => 0,
                'status' => 'draft',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
}

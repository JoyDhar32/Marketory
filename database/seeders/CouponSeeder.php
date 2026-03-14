<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            ['code' => 'WELCOME10', 'type' => 'percentage', 'value' => 10, 'description' => '10% off your first order', 'is_active' => true],
            ['code' => 'SAVE20',    'type' => 'fixed',      'value' => 20, 'description' => '$20 off orders over $100', 'minimum_order' => 100, 'is_active' => true],
            ['code' => 'FLASH50',   'type' => 'percentage', 'value' => 50, 'description' => 'Flash sale: 50% off', 'expires_at' => now()->addDays(7), 'is_active' => true],
            ['code' => 'FREESHIP',  'type' => 'fixed',      'value' => 5.99, 'description' => 'Free shipping coupon', 'is_active' => true],
            ['code' => 'VIP30',     'type' => 'percentage', 'value' => 30, 'description' => 'VIP member discount', 'minimum_order' => 50, 'is_active' => true],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShippingMethod;

class ShippingMethodSeeder extends Seeder
{
    public function run(): void
    {
        $shippingMethods = [
            [
                'name' => 'Giao hàng tiêu chuẩn',
                'description' => 'Giao hàng trong 3-5 ngày làm việc',
                'price' => 30000,
                'estimated_days' => 5,
                'status' => 1,
            ],
            [
                'name' => 'Giao hàng nhanh',
                'description' => 'Giao hàng trong 1-2 ngày làm việc',
                'price' => 50000,
                'estimated_days' => 2,
                'status' => 1,
            ],
            [
                'name' => 'Giao hàng hỏa tốc',
                'description' => 'Giao hàng trong ngày (khu vực nội thành)',
                'price' => 100000,
                'estimated_days' => 1,
                'status' => 1,
            ],
        ];

        foreach ($shippingMethods as $method) {
            ShippingMethod::create($method);
        }
    }
}

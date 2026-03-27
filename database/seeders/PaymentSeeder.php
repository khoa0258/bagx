<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $payments = [
            [
                'name' => 'Thanh toán khi nhận hàng (COD)',
                'description' => 'Thanh toán bằng tiền mặt khi nhận hàng',
                'status' => 1
            ],
            [
                'name' => 'Chuyển khoản ngân hàng',
                'description' => 'Chuyển khoản qua tài khoản ngân hàng',
                'status' => 1
            ],
            [
                'name' => 'Ví điện tử MoMo',
                'description' => 'Thanh toán qua ví MoMo',
                'status' => 1
            ]
        ];

        foreach ($payments as $payment) {
            Payment::create($payment);
        }
    }
}

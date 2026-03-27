<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\SubCategory;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Doanh thu: nên tính theo đơn đã thanh toán (thanh_toan = 1)
        $totalRevenue = Order::where('thanh_toan', 1)->sum('total_price');

        // VNPAY: id_payment = 0 (quy ước của bạn)
        $vnpayRevenue = Order::where('thanh_toan', 1)
            ->where('id_payment', 0)
            ->sum('total_price');

        $vnpayOrders = Order::where('thanh_toan', 1)
            ->where('id_payment', 0)
            ->count();

        // COD: id_payment = 1 (quy ước của bạn)
        $codRevenue = Order::where('thanh_toan', 1)
            ->where('id_payment', 1)
            ->sum('total_price');

        $codOrders = Order::where('thanh_toan', 1)
            ->where('id_payment', 1)
            ->count();

        // Các thống kê đang có
        $stats = [
            'total_products'   => Product::count(),
            'total_orders'     => Order::count(),
            'total_users'      => User::where('roles', 1)->count(),
            'total_categories' => SubCategory::count(),
            'pending_orders'   => Order::where('status', 1)->count(), // Đang xử lý
            // Trước đây bạn dùng status=3; chuyển sang thanh_toan=1 để phản ánh doanh thu thực nhận
            'total_revenue'    => $totalRevenue,

            // Thêm mới:
            'total_revenue_vnpay' => $vnpayRevenue,
            'vnpay_orders_count'  => $vnpayOrders,
            'total_revenue_cod'   => $codRevenue,
            'cod_orders_count'    => $codOrders,
        ];

        // Đơn hàng gần đây
        $recent_orders = Order::with(['user', 'payment', 'orderDetails.variant.product'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders'));
    }
}

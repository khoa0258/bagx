<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        try {
            $query = Order::with('user');

            if ($request->has('status') && $request->status !== '') {
                $query->where('status', $request->status);
            }

            if ($request->has('thanh_toan') && $request->thanh_toan !== '') {
                $query->where('thanh_toan', $request->thanh_toan);
            }

            $orders = $query->orderBy('created_at', 'desc')->paginate(10);

            return view('admin.orders.index', compact('orders'));
        } catch (\Exception $e) {
            Log::error('Error in OrderController@index: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', 'Không thể tải danh sách đơn hàng: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        $order->load('orderDetails.variant.product', 'payment', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $order->load('orderDetails.variant.product', 'payment', 'user');
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        try {
            $request->validate([
                'name' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'note' => 'nullable|string|max:500',
            ]);

            $order->update($request->only(['name', 'phone', 'address', 'note']));

            return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng được cập nhật thành công!');
        } catch (\Exception $e) {
            Log::error('Error in OrderController@update: ' . $e->getMessage());
            return redirect()->route('admin.orders.edit', $order->id)->with('error', 'Không thể cập nhật đơn hàng: ' . $e->getMessage());
        }
    }

    public function destroy(Order $order)
    {
        try {
            if (in_array($order->status, [0, 3])) {
                $order->delete();
                return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng được xóa thành công!');
            }
            return redirect()->route('admin.orders.index')->with('error', 'Chỉ có thể xóa đơn hàng ở trạng thái Đã hủy hoặc Hoàn thành!');
        } catch (\Exception $e) {
            Log::error('Error in OrderController@destroy: ' . $e->getMessage());
            return redirect()->route('admin.orders.index')->with('error', 'Không thể xóa đơn hàng: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        try {
            $request->validate([
                'status' => 'required|in:0,1,2,3',
            ]);

            $newStatus = $request->status;
            $currentStatus = $order->status;

            $allowedTransitions = [
                1 => [2], // Đang xử lý -> Đang giao
                2 => [3], // Đang giao -> Hoàn thành
                3 => [],  // Hoàn thành -> Không đổi
                0 => [],  // Hủy -> Không đổi
            ];

            if ($currentStatus !== $newStatus && !in_array($newStatus, $allowedTransitions[$currentStatus] ?? [])) {
                return redirect()->back()->with('error', 'Chuyển trạng thái không hợp lệ!');
            }

            $order->update([
                'status' => $newStatus,
            ]);

            return redirect()->back()->with('success', 'Trạng thái đơn hàng đã được cập nhật!');
        } catch (\Exception $e) {
            Log::error('Error in OrderController@updateStatus: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Không thể cập nhật trạng thái: ' . $e->getMessage());
        }
    }

    public function updatePayment(Request $request, Order $order)
    {
        try {
            $request->validate([
                'thanh_toan' => 'required|in:0,1',
            ]);

            $order->update([
                'thanh_toan' => $request->thanh_toan,
            ]);

            return redirect()->back()->with('success', 'Trạng thái thanh toán đã được cập nhật!');
        } catch (\Exception $e) {
            Log::error('Error in OrderController@updatePayment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Không thể cập nhật trạng thái thanh toán: ' . $e->getMessage());
        }
    }
}
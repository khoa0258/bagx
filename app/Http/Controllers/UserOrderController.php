<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
{
    $orders = auth()->user()->orders()->latest()->paginate(10);
    return view('frontend.orders.index', compact('orders')); // Thay đổi từ orders.index thành frontend.orders.index
}

 public function show(Order $order)
{
    // $this->authorize('view', $order); // Bỏ hoặc thay bằng kiểm tra thủ công
    if (auth()->id() !== $order->id_user) {
        abort(403, 'Unauthorized action.');
    }
    return view('frontend.orders.show', compact('order')); // Sửa đường dẫn view
}

  public function cancel(Request $request, Order $order)
{
    // Kiểm tra quyền thủ công thay vì $this->authorize('update', $order)
    if ($order->id_user && auth()->id() !== $order->id_user) {
        abort(403, 'Bạn không có quyền hủy đơn hàng này.');
    }
    if ($order->status == 1) {
        $order->update(['status' => 0]);
        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được hủy.');
    }
    return redirect()->route('orders.index')->with('error', 'Không thể hủy đơn hàng này.');
}

    public function reorder(Request $request, Order $order)
{
    // $this->authorize('view', $order); // Bỏ hoặc thay bằng kiểm tra thủ công
    if (auth()->id() !== $order->id_user) {
        abort(403, 'Unauthorized action.');
    }

    session()->forget('cart');

    $orderDetails = $order->orderDetails;
    if ($orderDetails->isEmpty()) {
        return redirect()->route('orders.index')->with('error', 'Đơn hàng không có sản phẩm để đặt lại.');
    }

    $cart = [];
    foreach ($orderDetails as $detail) {
        $variant = ProductVariant::find($detail->id_variant);
        if (!$variant) {
            \Illuminate\Support\Facades\Log::warning('ProductVariant not found for ID: ' . $detail->id_variant);
            return redirect()->route('orders.index')->with('error', 'Một số sản phẩm không còn tồn tại.');
        }
        $cart[$detail->id_variant] = [
            'quantity' => $detail->quantity,
            'price' => $variant->price,
            'subtotal' => $variant->price * $detail->quantity,
            'variant' => $variant,
        ];
    }

    session()->put('cart', $cart);
    return redirect()->route('checkout.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng để đặt lại.');
}
}
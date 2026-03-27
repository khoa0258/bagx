<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $variant = ProductVariant::findOrFail($request->variant_id);
        if ($request->quantity > $variant->stock) {
            return response()->json(['error' => 'Số lượng vượt quá tồn kho!'], 422);
        }

        $userId = Auth::id();
        $cart = Cart::firstOrCreate(
            ['user_id' => $userId, 'variant_id' => $request->variant_id],
            ['quantity' => 0]
        );

        $cart->increment('quantity', $request->quantity);

        return response()->json(['message' => 'Đã thêm vào giỏ hàng']);
    }

    public function buyNow(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $variant = ProductVariant::findOrFail($request->variant_id);
        if ($request->quantity > $variant->stock) {
            return response()->json(['error' => 'Số lượng vượt quá tồn kho!'], 422);
        }

        $userId = Auth::id();
        // Clear existing cart for this user
        Cart::where('user_id', $userId)->delete();

        // Add new item to cart
        Cart::create([
            'user_id' => $userId,
            'variant_id' => $request->variant_id,
            'quantity' => $request->quantity,
        ]);

        return response()->json(['message' => 'Đã thêm vào giỏ hàng, chuyển đến thanh toán']);
    }

    public function count()
    {
        $count = Cart::where('user_id', Auth::id())->sum('quantity');
        return response()->json(['count' => $count]);
    }

    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with(['variant.product'])
            ->get();
        $payments = \App\Models\Payment::where('status', 1)->get();
        $shippingMethods = \App\Models\ShippingMethod::where('status', 1)->get();

        return view('admin.checkout.index', compact('cartItems', 'payments', 'shippingMethods'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'id_payment' => 'required|exists:payments,id',
            'id_shipping_method' => 'required|exists:shipping_methods,id',
            'note' => 'nullable|string',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->with(['variant.product'])->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('admin.checkout')->with('error', 'Giỏ hàng trống!');
        }

        DB::transaction(function () use ($request, $cartItems) {
            $total = $cartItems->sum(function ($item) {
                return $item->variant->price * $item->quantity;
            });

            $shippingMethod = \App\Models\ShippingMethod::findOrFail($request->id_shipping_method);
            $total += $shippingMethod->fee;

            $order = Order::create([
                'id_user' => Auth::id(),
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'note' => $request->note,
                'total_price' => $total,
                'status' => 1, // Đang xử lý
                'thanh_toan' => 0, // Chưa thanh toán
                'id_payment' => $request->id_payment,
                'id_shipping_method' => $request->id_shipping_method,
                'order_date' => now(),
            ]);

            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'id_order' => $order->id,
                    'id_variant' => $item->variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->variant->price,
                ]);

                $item->variant->decrement('stock', $item->quantity);
            }

            // Clear cart after order
            Cart::where('user_id', Auth::id())->delete();
        });

        return redirect()->route('orders.confirmation')->with('success', 'Đơn hàng đã được đặt thành công!');
    }
}
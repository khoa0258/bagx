<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $details) {
            $variant = ProductVariant::with('product')->find($id);
            if ($variant) {
                $cartItems[$id] = [
                    'variant' => $variant,
                    'quantity' => $details['quantity'],
                    'price' => $variant->price,
                    'subtotal' => $variant->price * $details['quantity']
                ];
                $total += $cartItems[$id]['subtotal'];
            }
        }

        return view('frontend.cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $variant = ProductVariant::with('product')->findOrFail($request->variant_id);
        if ($request->quantity > $variant->stock) {
            return response()->json(['error' => 'Số lượng yêu cầu vượt quá tồn kho!'], 400);
        }

        $cart = session()->get('cart', []);
        $variantId = $request->variant_id;

        if (isset($cart[$variantId])) {
            $newQuantity = $cart[$variantId]['quantity'] + $request->quantity;
            if ($newQuantity > $variant->stock) {
                return response()->json(['error' => 'Số lượng trong giỏ hàng vượt quá tồn kho!'], 400);
            }
            $cart[$variantId]['quantity'] = $newQuantity;
        } else {
            $cart[$variantId] = [
                'quantity' => $request->quantity,
                'product_name' => $variant->product->name,
                'variant_option' => $variant->option,
                'price' => $variant->price
            ];
        }

        session()->put('cart', $cart);

        return response()->json(['success' => 'Đã thêm sản phẩm vào giỏ hàng!']);
    }

    public function buyNow(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $variant = ProductVariant::with('product')->findOrFail($request->variant_id);
        if ($request->quantity > $variant->stock) {
            return response()->json(['error' => 'Số lượng yêu cầu vượt quá tồn kho!'], 400);
        }

        // Xóa giỏ hàng cũ trong session
        session()->forget('cart');

        // Thêm sản phẩm vào giỏ hàng
        $cart = [
            $request->variant_id => [
                'quantity' => $request->quantity,
                'product_name' => $variant->product->name,
                'variant_option' => $variant->option,
                'price' => $variant->price
            ]
        ];
        session()->put('cart', $cart);

        return response()->json(['success' => 'Sản phẩm đã được thêm để đặt hàng!', 'redirect' => route('checkout.index')]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $variant = ProductVariant::findOrFail($request->variant_id);
        if ($request->quantity > $variant->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng vượt quá tồn kho!'
            ], 400);
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$request->variant_id])) {
            $cart[$request->variant_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật giỏ hàng!',
                'subtotal' => number_format($variant->price * $request->quantity),
                'total' => number_format($this->getCartTotal())
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Sản phẩm không có trong giỏ hàng!'
        ], 404);
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$request->variant_id])) {
            unset($cart[$request->variant_id]);
            session()->put('cart', $cart);
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng!',
                'total' => number_format($this->getCartTotal())
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Sản phẩm không có trong giỏ hàng!'
        ], 404);
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Đã xóa tất cả sản phẩm khỏi giỏ hàng!');
    }

    public function count()
    {
        $cart = session()->get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));
        return response()->json(['count' => $count]);
    }

    private function getCartTotal()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $id => $details) {
            $variant = ProductVariant::find($id);
            if ($variant) {
                $total += $variant->price * $details['quantity'];
            }
        }
        return $total;
    }
}
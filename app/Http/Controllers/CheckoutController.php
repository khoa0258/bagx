<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductVariant;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // KHÔNG bắt đăng nhập ở vnpay_return & success (tránh mất session khi redirect từ VNPAY)
        $this->middleware('auth')->except(['vnpay_return', 'vnpay_payment', 'success']);
    }

    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $details) {
            $variant = ProductVariant::with('product')->find($id);
            if ($variant) {
                $subtotal = $variant->price * $details['quantity'];
                $cartItems[$id] = [
                    'variant'  => $variant,
                    'quantity' => $details['quantity'],
                    'price'    => $variant->price,
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
            }
        }

        $payments = Payment::where('status', 1)->orderBy('sort')->get();
        $user = auth()->user();

        return view('frontend.checkout.index', compact('cartItems', 'total', 'payments', 'user'));
    }

   public function store(Request $request)
{
    Log::info('Checkout.store - Request data:', $request->all());

    $request->validate([
        'first_name'       => 'required|string|max:255',
        'last_name'        => 'required|string|max:255',
        'email'            => 'required|email|max:255',
        'phone'            => 'required|string|max:15',
        'shipping_address' => 'required|string|max:255',
        'id_payment'       => 'required|exists:payments,id',
        'note'             => 'nullable|string|max:200',
        'payment_type'     => 'required|in:cod,vnpay', // Ensure this field is validated
    ]);

    $cart = session()->get('cart', []);
    Log::info('Checkout.store - Cart data:', $cart);

    if (empty($cart)) {
        return response()->json(['message' => 'Giỏ hàng của bạn đang trống!'], 400);
    }

    DB::beginTransaction();

    try {
        $total = 0;
        $orderItems = [];

        foreach ($cart as $variantId => $details) {
            $variant = ProductVariant::with('product')->find($variantId);

            if (!$variant) {
                throw new \Exception('Sản phẩm không tồn tại!');
            }

            if ($variant->stock < $details['quantity']) {
                $pname = $variant->product->name ?? 'Sản phẩm';
                $opt   = $variant->option ?? '';
                throw new \Exception("{$pname} {$opt} không đủ hàng!");
            }

            $subtotal = $variant->price * $details['quantity'];
            $total += $subtotal;

            $orderItems[] = [
                'variant'  => $variant,
                'quantity' => $details['quantity'],
                'price'    => $variant->price,
                'subtotal' => $subtotal,
            ];
        }

        $payment = Payment::findOrFail($request->id_payment);

        // Lúc tạo đơn luôn để chưa thanh toán (0), chỉ set 1 khi VNPAY callback OK
        $thanh_toan_status = 0;

        $order = Order::create([
            'id_user'     => auth()->id(),
            'id_payment'  => $request->id_payment,
            'status'      => 1, // trạng thái: mới tạo
            'thanh_toan'  => $thanh_toan_status,
            'note'        => $request->note,
            'phone'       => $request->phone,
            'address'     => $request->shipping_address,
            'order_date'  => now(),
            'total_price' => $total,
        ]);

        foreach ($orderItems as $item) {
            OrderDetail::create([
                'id_order'   => $order->id,
                'id_variant' => $item['variant']->id,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);

            // trừ kho
            $item['variant']->decrement('stock', $item['quantity']);
        }

        // clear giỏ
        session()->forget('cart');
        DB::commit();

        // Nếu chọn vnpay → redirect sang VNPAY
        if ($request->payment_type === 'vnpay') {
            $vnp_Url = $this->generateVnpayUrl($order->id, $total, $request->ip());
            return response()->json(['redirect' => $vnp_Url]);
        }

        // Nếu thanh toán COD → chuyển hướng tới trang thành công luôn
        return response()->json(['redirect' => route('frontend.checkout.success', $order->id)]);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Checkout.store - Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        return response()->json(['message' => $e->getMessage()], 500);
    }
}


    /**
     * Tạo URL thanh toán VNPay
     */
    private function generateVnpayUrl($orderId, $total, $ipAddress = null)
    {
        $vnp_Url       = env('VNPAY_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html');
        $vnp_Returnurl = route('vnpay.return', [], true); // callback về đúng route
        $vnp_TmnCode   = env('VNPAY_TMN_CODE', 'AFYF142T');
        $vnp_HashSecret= env('VNPAY_HASH_SECRET', 'YE6KTJ65HT34WDGWEMLZCVD3WCW41P2M');

        $vnp_TxnRef    = (string)$orderId;
        $vnp_OrderInfo = 'Thanh toán đơn hàng #' . $orderId;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount    = (int)$total * 100; // vnpay yêu cầu x100
        $vnp_Locale    = 'vn';
        $vnp_IpAddr    = $ipAddress ?: request()->ip();

        $startTime = date("YmdHis");
        $expire    = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $inputData = [
            "vnp_Version"    => "2.1.0",
            "vnp_TmnCode"    => $vnp_TmnCode,
            "vnp_Amount"     => $vnp_Amount,
            "vnp_Command"    => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode"   => "VND",
            "vnp_IpAddr"     => $vnp_IpAddr,
            "vnp_Locale"     => $vnp_Locale,
            "vnp_OrderInfo"  => $vnp_OrderInfo,
            "vnp_OrderType"  => $vnp_OrderType,
            "vnp_ReturnUrl"  => $vnp_Returnurl,
            "vnp_TxnRef"     => $vnp_TxnRef,
            "vnp_ExpireDate" => $expire,
        ];

        ksort($inputData);

        $query = '';
        $hashdata = '';
        $i = 0;
        foreach ($inputData as $key => $value) {
            $encoded = urlencode($key) . "=" . urlencode((string)$value);
            $query .= $encoded . '&';
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode((string)$value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode((string)$value);
                $i = 1;
            }
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (!empty($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        Log::info('VNPAY URL generated: ' . $vnp_Url);
        Log::info('VNPAY Hash data: ' . $hashdata);

        return $vnp_Url;
    }

    /**
     * Tạo link VNPAY và (tuỳ biến) redirect ngay
     */
    public function vnpay_payment(Request $request)
    {
        $data = $request->all();
        $orderId = $data['order_id'] ?? rand(1, 999999);
        $total = (int)($data['total_vnpay'] ?? 0);

        $vnp_Url = $this->generateVnpayUrl($orderId, $total, $request->ip());

        $returnData = [
            'code'    => '00',
            'message' => 'success',
            'data'    => $vnp_Url,
        ];

        if (!empty($data['redirect'])) {
            return redirect()->away($vnp_Url);
        }

        return response()->json($returnData);
    }

    /**
     * Callback từ VNPAY
     */
    public function vnpay_return(Request $request)
    {
        Log::info('VNPay return data:', $request->all());

        $vnp_HashSecret   = env('VNPAY_HASH_SECRET', 'YE6KTJ65HT34WDGWEMLZCVD3WCW41P2M');
        $vnp_SecureHash   = $request->vnp_SecureHash;
        $inputData        = $request->except(['vnp_SecureHash', 'vnp_SecureHashType']);

        ksort($inputData);

        // build hashdata (giống cách gửi đi)
        $hashdata = '';
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode((string)$value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode((string)$value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        Log::info('VNPAY Return - Input Data: ', $inputData);
        Log::info('VNPAY Return - Hash data: ' . $hashdata);
        Log::info('VNPAY Return - Calculated SecureHash: ' . $secureHash);
        Log::info('VNPAY Return - Received SecureHash: ' . $vnp_SecureHash);

        $orderId = $request->vnp_TxnRef;
        $order = Order::find($orderId);

        if (!$order) {
            Log::error('VNPAY Return - Order not found: ' . $orderId);
            return redirect()->route('home')->with('error', 'Đơn hàng không tồn tại.');
        }

        if ($secureHash === $vnp_SecureHash && $request->vnp_ResponseCode == '00') {
            $vnpayPayment = Payment::where('name', 'Thanh toán VNPAY')->first();

            $order->update([
                'status'     => 2, // đã thanh toán/đã xác nhận
                'thanh_toan' => 1,
                'id_payment' => $vnpayPayment?->id ?? $order->id_payment,
            ]);

            return redirect()->route('frontend.checkout.success', $order->id)
                             ->with('success', 'Thanh toán VNPAY thành công!');
        } else {
            $order->update(['status' => 0]); // thất bại/hủy
            Log::error('VNPAY Return - Invalid signature or response code: ' . ($request->vnp_ResponseCode ?? 'N/A'));

            return redirect()->route('frontend.checkout.success', $order->id)
                             ->with('error', 'Thanh toán VNPAY thất bại. Mã lỗi: ' . ($request->vnp_ResponseCode ?? 'Invalid signature'));
        }
    }

    public function success($orderId)
    {
        $order = Order::with(['orderDetails.variant.product', 'payment'])->findOrFail($orderId);

        // Nếu đang đăng nhập nhưng order không thuộc user hiện tại → chặn xem
        if (auth()->check() && $order->id_user && $order->id_user !== auth()->id()) {
            return redirect()->route('home')->with('error', 'Bạn không có quyền xem đơn hàng này.');
        }

        // Giữ nguyên view path như bạn đang dùng
        return view('frontend.checkout.success', compact('order'));
    }
}

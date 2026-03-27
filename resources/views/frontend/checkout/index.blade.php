@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Giỏ hàng</a></li>
            <li class="breadcrumb-item active">Thanh toán</li>
        </ol>
    </nav>

    <h2 class="mb-4">Thanh toán</h2>

    <form method="POST" action="{{ route('checkout.store') }}" id="checkout-form">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <!-- Shipping Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-shipping-fast me-2"></i>Thông tin giao hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">Họ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                       id="first_name" name="first_name" value="{{ old('first_name', $user->first_name ?? '') }}" 
                                       tabindex="1" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                       id="last_name" name="last_name" value="{{ old('last_name', $user->last_name ?? '') }}" 
                                       tabindex="2" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email ?? '') }}" 
                                   tabindex="3" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" 
                                   tabindex="4" required autofocus>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                      id="shipping_address" name="shipping_address" rows="3" 
                                      tabindex="5" required>{{ old('shipping_address', $user->address ?? '') }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="note" class="form-label">Ghi chú đơn hàng</label>
                            <textarea class="form-control @error('note') is-invalid @enderror" 
                                      id="note" name="note" rows="2" tabindex="6" 
                                      placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn.">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Phương thức thanh toán</h5>
                    </div>
                    <div class="card-body">
                        @if($payments->isEmpty())
                            <div class="alert alert-warning" role="alert">
                                Hiện tại không có phương thức thanh toán nào khả dụng. Vui lòng liên hệ quản trị viên.
                            </div>
                        @else
                            @foreach($payments as $payment)
                            <div class="form-check mb-3">
                                <input class="form-check-input @error('id_payment') is-invalid @enderror" 
                                       type="radio" name="id_payment" id="payment_{{ $payment->id }}" 
                                       value="{{ $payment->id }}" {{ old('id_payment', 1) == $payment->id ? 'checked' : '' }} 
                                       tabindex="7" required>
                                <label class="form-check-label" for="payment_{{ $payment->id }}">
                                    <strong>{{ $payment->name }}</strong>
                                    @if($payment->description)
                                        <br><small class="text-muted">{{ $payment->description }}</small>
                                    @endif
                                </label>
                            </div>
                            @endforeach
                            @error('id_payment')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Order Summary -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Đơn hàng của bạn</h5>
                    </div>
                    <div class="card-body">
                        @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $item['variant']->product->name }}</h6>
                                <small class="text-muted">{{ $item['variant']->option }} × {{ $item['quantity'] }}</small>
                            </div>
                            <span class="fw-bold">{{ number_format($item['subtotal'], 0, ',', '.') }}đ</span>
                        </div>
                        @endforeach
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tạm tính:</span>
                            <span>{{ number_format($total, 0, ',', '.') }}đ</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span>Phí vận chuyển:</span>
                            <span class="text-success">Miễn phí</span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Tổng cộng:</strong>
                            <strong class="price-text">{{ number_format($total, 0, ',', '.') }}đ</strong>
                        </div>
                        
                        <!-- Nút Đặt hàng thông thường -->
                        <button type="submit" name="payment_type" value="cod" class="btn btn-primary w-100 btn-lg mb-2" tabindex="8">
                            <i class="fas fa-check me-2"></i>Đặt hàng
                        </button>
                        
                        <!-- Nút Thanh toán VNPAY -->
                        <button type="submit" name="payment_type" value="vnpay" class="btn btn-success w-100 btn-lg" tabindex="9">
                            <i class="fas fa-credit-card me-2"></i>Thanh toán VNPAY
                        </button>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                Bằng việc đặt hàng, bạn đồng ý với 
                                <a href="#" class="text-decoration-none">Điều khoản sử dụng</a> của chúng tôi.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- JavaScript để xử lý form -->
   <script>
document.getElementById('checkout-form').addEventListener('submit', function(event) {
    const paymentType = event.submitter.value;  // Xác định phương thức thanh toán
    const firstName = document.getElementById('first_name').value.trim();
    const lastName = document.getElementById('last_name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const shippingAddress = document.getElementById('shipping_address').value.trim();
    const paymentMethod = document.querySelector('input[name="id_payment"]:checked'); // Lấy phương thức thanh toán đã chọn

    // Validate các trường
    if (!firstName) {
        event.preventDefault();
        alert('Vui lòng nhập họ!');
        document.getElementById('first_name').focus();
        return false;
    }

    if (!lastName) {
        event.preventDefault();
        alert('Vui lòng nhập tên!');
        document.getElementById('last_name').focus();
        return false;
    }

    if (!email) {
        event.preventDefault();
        alert('Vui lòng nhập email!');
        document.getElementById('email').focus();
        return false;
    }

    if (!phone) {
        event.preventDefault();
        alert('Vui lòng nhập số điện thoại!');
        document.getElementById('phone').focus();
        return false;
    }

    if (!shippingAddress) {
        event.preventDefault();
        alert('Vui lòng nhập địa chỉ giao hàng!');
        document.getElementById('shipping_address').focus();
        return false;
    }

    if (!paymentMethod) {
        event.preventDefault();
        alert('Vui lòng chọn phương thức thanh toán!');
        document.getElementById('payment_1').focus();
        return false;
    }

    // Ngừng gửi form để xử lý thanh toán
    event.preventDefault();

    const formData = new FormData(this);  // Thu thập dữ liệu form
    formData.append('total_vnpay', '{{ $total }}');  // Thêm tổng số tiền vào formData
    formData.append('payment_type', paymentType);  // Thêm loại thanh toán

    // Gửi request POST cho thanh toán VNPAY
    fetch('{{ route('checkout.store') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'  // Gửi CSRF token để bảo mật
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.redirect) {
            // Nếu có URL redirect, thực hiện chuyển hướng người dùng
            window.location.href = data.redirect;  // Chuyển hướng tới trang VNPAY hoặc success
        } else {
            alert('Lỗi thanh toán VNPAY: ' + (data.message || 'Có lỗi xảy ra!'));
        }
    })
    .catch(error => {
        alert('Có lỗi xảy ra khi thanh toán VNPAY!');
        console.error(error);
    });
});
</script>


</div>
@endsection
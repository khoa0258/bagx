@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Đơn hàng của tôi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Đơn hàng #{{ $order->id }}</li>
        </ol>
    </nav>

    <h2 class="mb-4">Chi tiết đơn hàng #{{ $order->id }}</h2>

    <div class="row">
        <!-- Thông tin đơn hàng -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Mã đơn hàng:</strong> #{{ $order->id }}</p>
                            <p><strong>Ngày đặt:</strong> {{ $order->formatted_order_date }}</p>
                            <p><strong>Trạng thái:</strong> 
                                <span class="badge bg-{{ $order->status == 3 ? 'success' : ($order->status == 0 ? 'danger' : ($order->status == 2 ? 'info' : 'warning')) }}">
                                    {{ $order->status_text }}
                                </span>
                            </p>
                            <p><strong>Thanh toán:</strong> 
                                <span class="badge bg-{{ $order->thanh_toan ? 'success' : 'secondary' }}">
                                    {{ $order->payment_status_text }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Phương thức thanh toán:</strong> {{ $order->payment ? $order->payment->name : 'Không xác định' }}</p>
                            <p><strong>Ghi chú:</strong> {{ $order->note ?? 'Không có ghi chú' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sản phẩm trong đơn hàng -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Sản phẩm trong đơn hàng</h5>
                </div>
                <div class="card-body">
                    @if($order->orderDetails->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Biến thể</th>
                                        <th>Số lượng</th>
                                        <th>Đơn giá</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderDetails as $detail)
                                        <tr>
                                            <td>
                                                @if($detail->variant && $detail->variant->product)
                                                    {{ $detail->variant->product->name }}
                                                @else
                                                    Sản phẩm không tồn tại
                                                @endif
                                            </td>
                                            <td>{{ $detail->variant ? $detail->variant->option : 'Không có' }}</td>
                                            <td>{{ $detail->quantity }}</td>
                                            <td>{{ number_format($detail->price) }}đ</td>
                                            <td>{{ number_format($detail->price * $detail->quantity) }}đ</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end">
                            <h5>Tổng cộng: <strong>{{ number_format($order->total_price) }}đ</strong></h5>
                        </div>
                    @else
                        <p class="text-muted">Không có sản phẩm trong đơn hàng.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Thông tin khách hàng và giao hàng -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin khách hàng</h5>
                </div>
                <div class="card-body">
                    <p><strong>Họ và tên:</strong> {{ $order->user ? $order->user->last_name . ' ' . $order->user->first_name : 'Không xác định' }}</p>
                    <p><strong>Email:</strong> {{ $order->user ? $order->user->email : 'Không xác định' }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                    <p><strong>Địa chỉ giao hàng:</strong> {{ $order->address }}</p>
                </div>
            </div>

            <!-- Nút hành động -->
            <div class="card">
                <div class="card-body text-center">
                    <div class="btn-group" role="group">
                        @if($order->status == 1)
                            <form method="POST" action="{{ route('orders.cancel', $order->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm" 
                                        onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                                    <i class="fas fa-times me-1"></i>Hủy đơn hàng
                                </button>
                            </form>
                        @endif
                        @if(in_array($order->status, [0, 3]))
                            <form method="POST" action="{{ route('orders.reorder', $order->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-success btn-sm" 
                                        onclick="return confirm('Bạn có muốn đặt lại đơn hàng này?')">
                                    <i class="fas fa-redo me-1"></i>Đặt lại
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
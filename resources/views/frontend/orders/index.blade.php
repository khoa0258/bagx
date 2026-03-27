@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Đơn hàng của tôi</li>
        </ol>
    </nav>

    <h2 class="mb-4">Đơn hàng của tôi</h2>

    @if($orders->count() > 0)
        <div class="row">
            @foreach($orders as $order)
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Đơn hàng #{{ $order->id }}</h6>
                                <small class="text-muted">{{ $order->formatted_order_date }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $order->status == 3 ? 'success' : ($order->status == 0 ? 'danger' : 'warning') }} mb-1">
                                    {{ $order->status_text }}
                                </span>
                                <br>
                                <span class="badge bg-{{ $order->thanh_toan ? 'success' : 'secondary' }}">
                                    {{ $order->payment_status_text }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h6>Sản phẩm:</h6>
                                @foreach($order->orderDetails->take(3) as $detail)
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="flex-grow-1">
                                            <span>{{ $detail->variant && $detail->variant->product ? $detail->variant->product->name . ' - ' . $detail->variant->option : 'Sản phẩm không tồn tại' }}</span>
                                            <small class="text-muted"> × {{ $detail->quantity }}</small>
                                        </div>
                                        <!-- <span>{{ number_format($detail->price * $detail->quantity) }}đ</span> -->
                                    </div>
                                @endforeach
                                @if($order->orderDetails->count() > 3)
                                    <small class="text-muted">và {{ $order->orderDetails->count() - 3 }} sản phẩm khác...</small>
                                @endif
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="mb-3">
                                    <strong class="price-text">Tổng: {{ number_format($order->total_price) }}đ</strong>
                                </div>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>Chi tiết
                                    </a>
                                    @if($order->status == 1)
                                        <form method="POST" action="{{ route('orders.cancel', $order->id) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                    onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                                                <i class="fas fa-times me-1"></i>Hủy
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <!-- <div class="d-flex justify-content-center">
            {{ $orders->links() }}
        </div> -->
    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
            <h5>Bạn chưa có đơn hàng nào</h5>
            <p class="text-muted">Hãy bắt đầu mua sắm để tạo đơn hàng đầu tiên</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">
                <i class="fas fa-shopping-bag me-2"></i>Bắt đầu mua sắm
            </a>
        </div>
    @endif
</div>
@endsection
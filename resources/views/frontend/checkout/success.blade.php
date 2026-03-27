@extends('layouts.app')

@section('title', 'Cảm ơn bạn đã đặt hàng')

@section('content')
@php
    $fullName = trim((session('first_name') ?? '') . ' ' . (session('last_name') ?? ''));
    $nameToShow = $fullName !== '' ? $fullName : ($order->shipping_name ?? optional($order->user)->name ?? 'Không có tên');
    $emailToShow = $order->email ?? optional($order->user)->email ?? 'N/A';
    $phoneToShow = $order->phone ?? 'N/A';
    $addressToShow = $order->address ?? ($order->shipping_address ?? 'N/A');

    $paymentMethodText = $order->payment_method_text
        ?? (isset($order->payment_method) ? strtoupper($order->payment_method) : 'N/A');

    $statusText = method_exists($order, 'getStatusTextAttribute')
        ? $order->getStatusTextAttribute()
        : ($order->status_text ?? (isset($order->status) ? ucfirst($order->status) : 'N/A'));

    $orderDate = $order->formatted_order_date
        ?? optional($order->created_at)->timezone(config('app.timezone'))->format('d/m/Y H:i');

    $totalFormatted = number_format((float) ($order->total_price ?? 0), 0, ',', '.') . ' VNĐ';
@endphp

<style>
  /* Nền chuyển sắc nhẹ tương tự bản Tailwind */
  .bg-soft-gradient {
    background: linear-gradient(135deg, #eff6ff 0%, #e0e7ff 100%);
  }
  /* Viên tròn icon thành công */
  .success-circle {
    width: 64px; height: 64px;
    background: #dcfce7; color: #16a34a;
  }
  /* Nhãn trạng thái màu cam nhạt */
  .badge-soft-warning {
    background-color: #fff7ed; color: #9a3412;
  }
  /* Card bo góc lớn giống rounded-2xl */
  .rounded-2xl { border-radius: 1rem; }
</style>
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Giỏ hàng</a></li>
            <li class="breadcrumb-item"><a href="{{ route('checkout.index') }}">Thanh toán</a></li>
            <li class="breadcrumb-item active">Hoàn tất đơn hàng</li>
        </ol>
    </nav>
    </div>
<div class="bg-soft-gradient min-vh-100 d-flex align-items-center justify-content-center p-3">
  <div class="card shadow-lg border-0 rounded-2xl" style="max-width: 560px; width: 100%;">
    <div class="card-body p-4 p-md-5">
      <!-- Header -->
      <div class="text-center mb-4">
        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 success-circle">
          <!-- SVG check -->
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 13l4 4L19 7"/>
          </svg>
        </div>
        <h1 class="h4 fw-bold text-dark mb-2">Cảm ơn bạn đã đặt hàng!</h1>
        <span class="badge text-primary bg-primary-subtle px-3 py-2 rounded-pill">
          Mã đơn hàng: #{{ $order->id }}
        </span>
      </div>

      <!-- Thông tin đơn hàng -->
      <div class="mb-4">
        <div class="border-bottom pb-2 mb-2 d-flex justify-content-between">
          <span class="text-muted big">Họ và tên:</span>
          <span class="fw-medium text-dark">{{ $nameToShow }}</span>
        </div>

        <div class="border-bottom pb-2 mb-2 d-flex justify-content-between">
          <span class="text-muted big">Email:</span>
          <span class="fw-medium text-dark">{{ $emailToShow }}</span>
        </div>

        <div class="border-bottom pb-2 mb-2 d-flex justify-content-between">
          <span class="text-muted big">Số điện thoại:</span>
          <span class="fw-medium text-dark">{{ $phoneToShow }}</span>
        </div>

        <div class="border-bottom pb-2 mb-2 d-flex justify-content-between">
          <span class="text-muted big">Địa chỉ giao hàng:</span>
          <span class="fw-medium text-dark">{{ $addressToShow }}</span>
        </div>

        <div class="border-bottom pb-2 mb-2 d-flex justify-content-between">
          <span class="text-muted big">Phương thức thanh toán:</span>
          <span class="fw-semibold text-primary">{{ $paymentMethodText }}</span>
        </div>

        <div class="border-bottom pb-2 mb-2 d-flex justify-content-between align-items-center">
          <span class="text-muted big">Trạng thái đơn hàng:</span>
          <span class="badge badge-soft-warning rounded-pill px-3 py-2">{{ $statusText }}</span>
        </div>

        <div class="border-bottom pb-2 mb-2 d-flex justify-content-between">
          <span class="text-muted big">Ngày đặt hàng:</span>
          <span class="fw-medium text-dark">{{ $orderDate }}</span>
        </div>

        <div class="bg-body-tertiary rounded-3 p-3 d-flex justify-content-between align-items-center">
          <span class="fw-semibold">Tổng tiền:</span>
          <span class="fs-4 fw-bold text-success">{{ $totalFormatted }}</span>
        </div>
      </div>

      <!-- Buttons -->
      <div class="d-grid gap-2">
        <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
          🏠 Quay về trang chủ
        </a>
        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-secondary btn-lg">
          📋 Xem chi tiết đơn hàng
        </a>
      </div>

      <p class="mt-4 text-center text-muted small">
        Chúng tôi sẽ gửi thông báo cập nhật trạng thái đơn hàng qua email và SMS.
      </p>
    </div>
  </div>
</div>
@endsection

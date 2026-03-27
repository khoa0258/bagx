@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa đơn hàng')
@section('page-title', 'Chỉnh sửa đơn hàng #' . $order->id)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Thông tin đơn hàng</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                    @csrf
                    @method('PATCH')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Trạng thái đơn hàng</label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                    <option value="0" {{ old('status', $order->status) == 0 ? 'selected' : '' }}>Chờ xử lý</option>
                                    <option value="1" {{ old('status', $order->status) == 1 ? 'selected' : '' }}>Đang xử lý</option>
                                    <option value="2" {{ old('status', $order->status) == 2 ? 'selected' : '' }}>Đã giao</option>
                                    <option value="3" {{ old('status', $order->status) == 3 ? 'selected' : '' }}>Đã hủy</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="thanh_toan" class="form-label">Trạng thái thanh toán</label>
                                <select class="form-select @error('thanh_toan') is-invalid @enderror" 
                                        id="thanh_toan" name="thanh_toan" required>
                                    <option value="0" {{ old('thanh_toan', $order->thanh_toan) == 0 ? 'selected' : '' }}>Chưa thanh toán</option>
                                    <option value="1" {{ old('thanh_toan', $order->thanh_toan) == 1 ? 'selected' : '' }}>Đã thanh toán</option>
                                </select>
                                @error('thanh_toan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_payment" class="form-label">Phương thức thanh toán</label>
                                <select class="form-select" id="id_payment" name="id_payment">
                                    <option value="">Chọn phương thức</option>
                                    @foreach($payments as $payment)
                                        <option value="{{ $payment->id }}" 
                                            {{ old('id_payment', $order->id_payment) == $payment->id ? 'selected' : '' }}>
                                            {{ $payment->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_shipping_method" class="form-label">Phương thức vận chuyển</label>
                                <select class="form-select" id="id_shipping_method" name="id_shipping_method">
                                    <option value="">Chọn phương thức</option>
                                    @foreach($shippingMethods as $method)
                                        <option value="{{ $method->id }}" 
                                            {{ old('id_shipping_method', $order->id_shipping_method) == $method->id ? 'selected' : '' }}>
                                            {{ $method->name }} ({{ number_format($method->price) }}đ)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="shipping_address" class="form-label">Địa chỉ giao hàng *</label>
                        <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                  id="shipping_address" name="shipping_address" rows="3" required>{{ old('shipping_address', $order->shipping_address) }}</textarea>
                        @error('shipping_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại *</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', $order->phone) }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="shipping_fee" class="form-label">Phí vận chuyển (đ)</label>
                                <input type="number" class="form-control" id="shipping_fee" name="shipping_fee" 
                                       value="{{ old('shipping_fee', $order->shipping_fee ?? 0) }}" min="0" step="0.01">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="discount_amount" class="form-label">Số tiền giảm giá (đ)</label>
                                <input type="number" class="form-control" id="discount_amount" name="discount_amount" 
                                       value="{{ old('discount_amount', $order->discount_amount ?? 0) }}" min="0" step="0.01">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="note" class="form-label">Ghi chú</label>
                        <textarea class="form-control" id="note" name="note" rows="3">{{ old('note', $order->note) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Cập nhật đơn hàng
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Thông tin khách hàng</h5>
            </div>
            <div class="card-body">
                <p><strong>Tên:</strong> {{ $order->user->first_name }} {{ $order->user->last_name }}</p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                <p><strong>Điện thoại:</strong> {{ $order->user->phone }}</p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Chi tiết đơn hàng</h5>
            </div>
            <div class="card-body">
                @foreach($order->orderDetails as $detail)
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <strong>{{ $detail->variant->product->name }}</strong><br>
                            <small class="text-muted">{{ $detail->variant->option }}</small><br>
                            <small>SL: {{ $detail->quantity }}</small>
                        </div>
                        <div class="text-end">
                            {{ number_format($detail->price * $detail->quantity) }}đ
                        </div>
                    </div>
                    <hr>
                @endforeach
                
                <div class="d-flex justify-content-between">
                    <strong>Tổng cộng:</strong>
                    <strong>{{ number_format($order->total) }}đ</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

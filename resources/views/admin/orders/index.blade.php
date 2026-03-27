@extends('admin.layouts.app')

@section('title', 'Quản lý đơn hàng')
@section('page-title', 'Quản lý đơn hàng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Danh sách đơn hàng</h4>
    
    <!-- Filter Form -->
    <form method="GET" action="{{ route('admin.orders.index') }}" class="d-flex gap-2">
        <select class="form-select" name="status" style="width: auto;">
            <option value="">Tất cả trạng thái</option>
            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Đã hủy</option>
            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Đang xử lý</option>
            <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Đang giao</option>
            <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Hoàn thành</option>
        </select>
        <select class="form-select" name="thanh_toan" style="width: auto;">
            <option value="">Tất cả thanh toán</option>
            <option value="0" {{ request('thanh_toan') == '0' ? 'selected' : '' }}>Chưa thanh toán</option>
            <option value="1" {{ request('thanh_toan') == '1' ? 'selected' : '' }}>Đã thanh toán</option>
        </select>
        <button type="submit" class="btn btn-outline-primary">Lọc</button>
    </form>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
           <table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Số điện thoại</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Thanh toán</th>
            <th>Ngày đặt</th>
            <!-- <th>Thao tác</th> -->
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
<td>{{ optional($order->user)->full_name ?? ($order->name ?? 'Không có tên') }}</td>
                <td class="fw-bold text-primary">{{ number_format($order->total_price) }}đ</td>
                <td>
                    <span class="badge bg-{{ $order->status == 3 ? 'success' : ($order->status == 0 ? 'danger' : 'warning') }}">
                        {{ $order->status_text }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-{{ $order->thanh_toan ? 'success' : 'secondary' }}">
                        {{ $order->payment_status_text }}
                    </span>
                </td>
                <td>{{ $order->formatted_order_date }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i> Xem
                    </a>
                    <!-- chức năng xoá đơn hàng -->
                    <!-- <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline" 
                          onsubmit="return confirm('Bạn có chắc muốn xóa đơn hàng này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </form> -->
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">Chưa có đơn hàng nào</td>
            </tr>
        @endforelse
    </tbody>
</table>
        </div>

        <!-- Pagination -->
        <!-- <div class="d-flex justify-content-center">
            {{ $orders->appends(request()->query())->links() }}
        </div> -->
    </div>
</div>
@endsection
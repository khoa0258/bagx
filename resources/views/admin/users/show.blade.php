@extends('admin.layouts.app')

@section('title', 'Chi tiết User')
@section('page-title', 'Chi tiết User')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Thông tin User: {{ $user->full_name }}</h4>
        <div class="row">
            <div class="col-md-6">
                <p><strong>ID:</strong> {{ $user->id }}</p>
                <p><strong>Tên đầy đủ:</strong> {{ $user->full_name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Số điện thoại:</strong> {{ $user->phone }}</p>
                <p><strong>Địa chỉ:</strong> {{ $user->address ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Vai trò:</strong> {{ $user->roles == 2 ? 'Admin' : 'User' }}</p>
                <p><strong>Trạng thái:</strong> 
                    <span class="badge bg-{{ $user->account_lock ? 'success' : 'danger' }}">
                        {{ $user->account_lock ? 'Hoạt động' : 'Khóa' }}
                    </span>
                </p>
                <p><strong>Ngày tạo:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Ngày cập nhật:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Chỉnh sửa
            </a>
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                  class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Xóa
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
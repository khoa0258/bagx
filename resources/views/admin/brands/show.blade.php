@extends('admin.layouts.app')

@section('title', 'Chi tiết Thương Hiệu')
@section('page-title', 'Chi tiết Thương Hiệu')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $brand->name }}</h5>
        <div class="row">
            <div class="col-md-6">
                <p><strong>ID:</strong> {{ $brand->id }}</p>
                <p><strong>Tên Thương Hiệu:</strong> {{ $brand->name }}</p>
                <p><strong>Slug:</strong> {{ $brand->slug }}</p>
                <p><strong>Thứ Tự:</strong> {{ $brand->sort ?? 'N/A' }}</p>
                <p><strong>Trạng Thái:</strong> 
                    <span class="badge bg-{{ $brand->status ? 'success' : 'danger' }}">
                        {{ $brand->status ? 'Hoạt động' : 'Ẩn' }}
                    </span>
                </p>
            </div>
            <div class="col-md-6">
                <p><strong>Logo:</strong></p>
                @if ($brand->logo)
                                        <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" style="max-width: 100px; max-height: 50px;">
                @else
                    <p>N/A</p>
                @endif
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-primary">Chỉnh sửa</a>
            <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
</div>
@endsection
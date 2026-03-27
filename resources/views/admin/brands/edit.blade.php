@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa Thương Hiệu')
@section('page-title', 'Chỉnh sửa Thương Hiệu')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.brands.update', $brand->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-group mb-3">
                <label for="name">Tên Thương Hiệu</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $brand->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="logo">Logo</label>
                <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror">
                @if ($brand->logo)
                     <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" style="max-width: 100px; max-height: 50px;">
                @endif
                @error('logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="slug">Slug</label>
                <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $brand->slug) }}">
                @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="sort">Thứ Tự</label>
                <input type="number" name="sort" id="sort" class="form-control @error('sort') is-invalid @enderror" value="{{ old('sort', $brand->sort) }}">
                @error('sort')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="status">Trạng Thái</label>
                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                    <option value="1" {{ old('status', $brand->status) == '1' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="0" {{ old('status', $brand->status) == '0' ? 'selected' : '' }}>Ẩn</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</div>
@endsection
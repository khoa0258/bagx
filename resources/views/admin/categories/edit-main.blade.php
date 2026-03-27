@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa danh mục chính')
@section('page-title', 'Chỉnh sửa danh mục chính: ' . $category->name)

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.categories.update-main', $category) }}">
            @csrf
            @method('PATCH')
            
            <div class="mb-3">
                <label for="name" class="form-label">Tên danh mục chính *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Cập nhật danh mục
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

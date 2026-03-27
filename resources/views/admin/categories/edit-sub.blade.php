@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa danh mục con')
@section('page-title', 'Chỉnh sửa danh mục con: ' . $category->name)

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.categories.update-sub', $category) }}">
            @csrf
            @method('PATCH')
            
            <div class="mb-3">
                <label for="id_main_category" class="form-label">Danh mục chính *</label>
                <select class="form-select @error('id_main_category') is-invalid @enderror" 
                        id="id_main_category" name="id_main_category" required>
                    <option value="">Chọn danh mục chính</option>
                    @foreach($mainCategories as $mainCategory)
                        <option value="{{ $mainCategory->id }}" 
                            {{ old('id_main_category', $category->id_main_category) == $mainCategory->id ? 'selected' : '' }}>
                            {{ $mainCategory->name }}
                        </option>
                    @endforeach
                </select>
                @error('id_main_category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Tên danh mục con *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select class="form-select" id="status" name="status">
                        <option value="1" {{ old('status', $category->status) == 1 ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ old('status', $category->status) == 0 ? 'selected' : '' }}>Ẩn</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="sort" class="form-label">Thứ tự sắp xếp</label>
                    <input type="number" class="form-control" id="sort" name="sort" 
                           value="{{ old('sort', $category->sort) }}" min="0">
                </div>
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

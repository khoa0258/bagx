@extends('admin.layouts.app')

@section('title', 'Quản lý danh mục')
@section('page-title', 'Quản lý danh mục')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Danh sách danh mục</h4>
    <div class="btn-group" role="group">
        <a href="{{ route('admin.categories.create-main') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm danh mục chính
        </a>
        <a href="{{ route('admin.categories.create-sub') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm danh mục con
        </a>
    </div>
</div>

<!-- Main Categories -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Danh mục chính</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Số danh mục con</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mainCategories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->subCategories->count() }}</td>
                        <td>{{ $category->created_at ? $category->created_at->format('d/m/Y') : 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Chưa có danh mục chính nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Sub Categories -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Danh mục con</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Danh mục chính</th>
                        <th>Trạng thái</th>
                        <th>Thứ tự</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subCategories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->mainCategory->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $category->status ? 'success' : 'danger' }}">
                                {{ $category->status ? 'Hoạt động' : 'Ẩn' }}
                            </span>
                        </td>
                        <td>{{ $category->sort ?? 0 }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" 
                                      class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Chưa có danh mục con nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <!-- <div class="d-flex justify-content-center">
            {{ $subCategories->links() }}
        </div> -->
    </div>
</div>
@endsection

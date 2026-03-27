@extends('layouts.app')

@section('title', 'Sản phẩm')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Sản phẩm</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-filter me-2"></i>Bộ lọc</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('products.index') }}">
                        <!-- Search -->
                        <div class="mb-3">
                            <label class="form-label">Tìm kiếm</label>
                            <input type="text" class="form-control" name="search" 
                                   value="{{ request('search') }}" placeholder="Nhập tên sản phẩm...">
                        </div>

                        <!-- Category Filter -->
                        <div class="mb-3">
                            <label class="form-label">Danh mục</label>
                            <select class="form-select" name="category">
                                <option value="">Tất cả danh mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->mainCategory->name }} - {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Brand Filter -->
                        <div class="mb-3">
                            <label class="form-label">Thương hiệu</label>
                            <select class="form-select" name="brand">
                                <option value="">Tất cả thương hiệu</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" 
                                            {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sort -->
                        <div class="mb-3">
                            <label class="form-label">Sắp xếp</label>
                            <select class="form-select" name="sort">
                                <option value="">Mặc định</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Phổ biến</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá thấp đến cao</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá cao đến thấp</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Lọc sản phẩm
                        </button>
                        
                        @if(request()->hasAny(['search', 'category', 'brand', 'sort']))
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                                <i class="fas fa-times me-2"></i>Xóa bộ lọc
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <!-- Results Info -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>Sản phẩm</h4>
                <span class="text-muted">Hiển thị {{ $products->count() }} trong {{ $products->total() }} sản phẩm</span>
            </div>

            @if($products->count() > 0)
                <div class="row g-4">
                    @foreach($products as $product)
                    <div class="col-md-6 col-xl-4">
                        <div class="card product-card h-100">
                            <div class="position-relative">
                                @if($product->main_image)
                                    <!-- Fixed image URL from img_products to img_url -->
                                    <img src="{{ asset($product->main_image->img_url) }}" 
                                         class="card-img-top product-image" alt="{{ $product->name }}">
                                @else
                                    <img src="/placeholder.svg?height=250&width=300" 
                                         class="card-img-top product-image" alt="{{ $product->name }}">
                                @endif
                                @if($product->discount)
                                    <span class="position-absolute top-0 start-0 badge bg-danger m-2">
                                        -{{ $product->discount->value }}{{ $product->discount->type == 'percent' ? '%' : 'đ' }}
                                    </span>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">{{ $product->name }}</h6>
                                <p class="text-muted small mb-2">
                                    {{ $product->category->name ?? 'N/A' }} • {{ $product->brand->name ?? 'N/A' }}
                                </p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="price-text">
                                            @if($product->variants->count() > 0)
                                                {{ number_format($product->min_price) }}đ
                                                @if($product->min_price != $product->max_price)
                                                    - {{ number_format($product->max_price) }}đ
                                                @endif
                                            @endif
                                        </span>
                                        <small class="text-muted">
                                            <i class="fas fa-eye me-1"></i>{{ $product->views }}
                                        </small>
                                    </div>
                                    <a href="{{ route('products.show', $product->slug) }}" 
                                       class="btn btn-primary w-100">
                                        <i class="fas fa-eye me-2"></i>Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h5>Không tìm thấy sản phẩm nào</h5>
                    <p class="text-muted">Hãy thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        Xem tất cả sản phẩm
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

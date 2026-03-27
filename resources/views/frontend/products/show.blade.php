@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body p-0">
                    @if($product->images->count() > 0)
                        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($product->images as $index => $image)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ asset($image->img_url) }}" class="d-block w-100" 
                                         style="height: 400px; object-fit: cover;" alt="{{ $product->name }}">
                                </div>
                                @endforeach
                            </div>
                            @if($product->images->count() > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            @endif
                        </div>
                    @else
                        <img src="/placeholder.svg?height=250&width=300" 
                             class="w-100" style="height: 400px; object-fit: cover;" alt="{{ $product->name }}">
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="h3 mb-3">{{ $product->name }}</h1>
                    
                    <div class="mb-3">
                        <span class="badge bg-secondary me-2">{{ $product->category->name ?? 'N/A' }}</span>
                        <span class="badge bg-info">{{ $product->brand->name ?? 'N/A' }}</span>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <span class="h4 price-text mb-0">
                                @if($product->variants->count() > 0)
                                    {{ number_format($product->min_price) }}đ
                                    @if($product->min_price != $product->max_price)
                                        - {{ number_format($product->max_price) }}đ
                                    @endif
                                @endif
                            </span>
                            @if($product->discount)
                                <span class="badge bg-danger">
                                    Giảm {{ $product->discount->value }}{{ $product->discount->type == 'percent' ? '%' : 'đ' }}
                                </span>
                            @endif
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-eye me-1"></i>{{ $product->views }} lượt xem
                        </small>
                    </div>

                    @if($product->description)
                        <div class="mb-4">
                            <h6>Mô tả sản phẩm</h6>
                            <p class="text-muted">{{ $product->description }}</p>
                        </div>
                    @endif

                    <!-- Product Variants -->
                    @if($product->variants->count() > 0)
                        <div class="mb-4">
                            <h6>Tùy chọn sản phẩm</h6>
                            <!-- Form for Add to Cart -->
                            <form id="add-to-cart-form" method="POST" action="{{ route('cart.add') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <div class="mb-3">
                                    <select class="form-select" name="variant_id" id="variant-select" required>
                                        <option value="">Chọn tùy chọn</option>
                                        @foreach($product->variants as $variant)
                                            <option value="{{ $variant->id }}" 
                                                    data-price="{{ $variant->price }}" 
                                                    data-stock="{{ $variant->stock }}">
                                                {{ $variant->option }} - {{ number_format($variant->price) }}đ 
                                                (Còn {{ $variant->stock }} sản phẩm)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Số lượng</label>
                                    <div class="input-group" style="max-width: 150px;">
                                        <button type="button" class="btn btn-outline-secondary" id="decrease-qty">-</button>
                                        <input type="number" class="form-control text-center" name="quantity" 
                                               id="quantity" value="1" min="1" max="1">
                                        <button type="button" class="btn btn-outline-secondary" id="increase-qty">+</button>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg" id="add-to-cart-btn" disabled>
                                        <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ hàng
                                    </button>
                                </div>
                            </form>
                            <!-- Form for Buy Now -->
                            <form id="buy-now-form" method="POST" action="{{ route('cart.buy-now') }}">
                                @csrf
                                <input type="hidden" name="variant_id" id="buy-now-variant-id">
                                <input type="hidden" name="quantity" id="buy-now-quantity">
                                <div class="d-grid gap-2 mt-2">
                                    <button type="submit" class="btn btn-success btn-lg" id="buy-now-btn" disabled>
                                        <i class="fas fa-bolt me-2"></i>Mua ngay
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <!-- Product Attributes -->
                    @if($product->attributes->count() > 0)
                        <div class="mb-4">
                            <h6>Thông số kỹ thuật</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    @foreach($product->attributes as $attribute)
                                    <tr>
                                        <td class="fw-semibold">{{ $attribute->key }}</td>
                                        <td>{{ $attribute->value }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <section class="mt-5">
            <h4 class="mb-4">Sản phẩm liên quan</h4>
            <div class="row g-4">
                @foreach($relatedProducts as $relatedProduct)
                <div class="col-md-6 col-lg-3">
                    <div class="card product-card h-100">
                        <div class="position-relative">
                            @if($relatedProduct->main_image)
                                <img src="{{ asset($relatedProduct->main_image->img_url) }}" 
                                     class="card-img-top product-image" alt="{{ $relatedProduct->name }}">
                            @else
                                <img src="/placeholder.svg?height=250&width=300" 
                                     class="card-img-top product-image" alt="{{ $relatedProduct->name }}">
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">{{ $relatedProduct->name }}</h6>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price-text">
                                        {{ number_format($relatedProduct->min_price) }}đ
                                    </span>
                                    <a href="{{ route('products.show', $relatedProduct->slug) }}" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const variantSelect = document.getElementById('variant-select');
    const quantityInput = document.getElementById('quantity');
    const addToCartBtn = document.getElementById('add-to-cart-btn');
    const buyNowBtn = document.getElementById('buy-now-btn');
    const buyNowForm = document.getElementById('buy-now-form');
    const buyNowVariantId = document.getElementById('buy-now-variant-id');
    const buyNowQuantity = document.getElementById('buy-now-quantity');
    const decreaseBtn = document.getElementById('decrease-qty');
    const increaseBtn = document.getElementById('increase-qty');

    // Handle variant selection
    variantSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const stock = parseInt(selectedOption.dataset.stock);
            quantityInput.max = stock;
            quantityInput.value = 1;
            addToCartBtn.disabled = false;
            buyNowBtn.disabled = false;
            buyNowVariantId.value = selectedOption.value;
            buyNowQuantity.value = quantityInput.value;
        } else {
            addToCartBtn.disabled = true;
            buyNowBtn.disabled = true;
            buyNowVariantId.value = '';
            buyNowQuantity.value = '';
        }
    });

    // Quantity controls
    decreaseBtn.addEventListener('click', function() {
        const current = parseInt(quantityInput.value);
        if (current > 1) {
            quantityInput.value = current - 1;
            buyNowQuantity.value = quantityInput.value;
        }
    });

    increaseBtn.addEventListener('click', function() {
        const current = parseInt(quantityInput.value);
        const max = parseInt(quantityInput.max);
        if (current < max) {
            quantityInput.value = current + 1;
            buyNowQuantity.value = quantityInput.value;
        }
    });

    quantityInput.addEventListener('change', function() {
        const value = parseInt(this.value);
        const max = parseInt(this.max);
        if (value >= 1 && value <= max) {
            buyNowQuantity.value = this.value;
        } else {
            this.value = 1;
            buyNowQuantity.value = 1;
            alert('Số lượng không hợp lệ!');
        }
    });

    // Add to cart form submission
    document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update cart count
                updateCartCount();
                alert(data.success);
            } else {
                alert(data.error || 'Có lỗi xảy ra, vui lòng thử lại!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra, vui lòng thử lại!');
        });
    });

    // Buy now form submission
    buyNowForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect; // Chuyển hướng đến /checkout
            } else {
                alert(data.error || 'Có lỗi xảy ra khi mua ngay, vui lòng thử lại!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi mua ngay, vui lòng thử lại!');
        });
    });

    function updateCartCount() {
        fetch('{{ route('cart.count') }}')
            .then(response => response.json())
            .then(data => {
                const cartCountElement = document.querySelector('.cart-count');
                if (cartCountElement) {
                    cartCountElement.textContent = data.count;
                }
            })
            .catch(error => console.error('Error updating cart count:', error));
    }
});
</script>
@endpush
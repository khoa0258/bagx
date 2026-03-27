<?php $__env->startSection('title', $product->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('products.index')); ?>">Sản phẩm</a></li>
            <li class="breadcrumb-item active"><?php echo e($product->name); ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body p-0">
                    <?php if($product->images->count() > 0): ?>
                        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="carousel-item <?php echo e($index == 0 ? 'active' : ''); ?>">
                                    <img src="<?php echo e(asset($image->img_url)); ?>" class="d-block w-100" 
                                         style="height: 400px; object-fit: cover;" alt="<?php echo e($product->name); ?>">
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php if($product->images->count() > 1): ?>
                                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <img src="/placeholder.svg?height=250&width=300" 
                             class="w-100" style="height: 400px; object-fit: cover;" alt="<?php echo e($product->name); ?>">
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="h3 mb-3"><?php echo e($product->name); ?></h1>
                    
                    <div class="mb-3">
                        <span class="badge bg-secondary me-2"><?php echo e($product->category->name ?? 'N/A'); ?></span>
                        <span class="badge bg-info"><?php echo e($product->brand->name ?? 'N/A'); ?></span>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <span class="h4 price-text mb-0">
                                <?php if($product->variants->count() > 0): ?>
                                    <?php echo e(number_format($product->min_price)); ?>đ
                                    <?php if($product->min_price != $product->max_price): ?>
                                        - <?php echo e(number_format($product->max_price)); ?>đ
                                    <?php endif; ?>
                                <?php endif; ?>
                            </span>
                            <?php if($product->discount): ?>
                                <span class="badge bg-danger">
                                    Giảm <?php echo e($product->discount->value); ?><?php echo e($product->discount->type == 'percent' ? '%' : 'đ'); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-eye me-1"></i><?php echo e($product->views); ?> lượt xem
                        </small>
                    </div>

                    <?php if($product->description): ?>
                        <div class="mb-4">
                            <h6>Mô tả sản phẩm</h6>
                            <p class="text-muted"><?php echo e($product->description); ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- Product Variants -->
                    <?php if($product->variants->count() > 0): ?>
                        <div class="mb-4">
                            <h6>Tùy chọn sản phẩm</h6>
                            <!-- Form for Add to Cart -->
                            <form id="add-to-cart-form" method="POST" action="<?php echo e(route('cart.add')); ?>">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                
                                <div class="mb-3">
                                    <select class="form-select" name="variant_id" id="variant-select" required>
                                        <option value="">Chọn tùy chọn</option>
                                        <?php $__currentLoopData = $product->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($variant->id); ?>" 
                                                    data-price="<?php echo e($variant->price); ?>" 
                                                    data-stock="<?php echo e($variant->stock); ?>">
                                                <?php echo e($variant->option); ?> - <?php echo e(number_format($variant->price)); ?>đ 
                                                (Còn <?php echo e($variant->stock); ?> sản phẩm)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <form id="buy-now-form" method="POST" action="<?php echo e(route('cart.buy-now')); ?>">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="variant_id" id="buy-now-variant-id">
                                <input type="hidden" name="quantity" id="buy-now-quantity">
                                <div class="d-grid gap-2 mt-2">
                                    <button type="submit" class="btn btn-success btn-lg" id="buy-now-btn" disabled>
                                        <i class="fas fa-bolt me-2"></i>Mua ngay
                                    </button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <!-- Product Attributes -->
                    <?php if($product->attributes->count() > 0): ?>
                        <div class="mb-4">
                            <h6>Thông số kỹ thuật</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <?php $__currentLoopData = $product->attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="fw-semibold"><?php echo e($attribute->key); ?></td>
                                        <td><?php echo e($attribute->value); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <?php if($relatedProducts->count() > 0): ?>
        <section class="mt-5">
            <h4 class="mb-4">Sản phẩm liên quan</h4>
            <div class="row g-4">
                <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card product-card h-100">
                        <div class="position-relative">
                            <?php if($relatedProduct->main_image): ?>
                                <img src="<?php echo e(asset($relatedProduct->main_image->img_url)); ?>" 
                                     class="card-img-top product-image" alt="<?php echo e($relatedProduct->name); ?>">
                            <?php else: ?>
                                <img src="/placeholder.svg?height=250&width=300" 
                                     class="card-img-top product-image" alt="<?php echo e($relatedProduct->name); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title"><?php echo e($relatedProduct->name); ?></h6>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price-text">
                                        <?php echo e(number_format($relatedProduct->min_price)); ?>đ
                                    </span>
                                    <a href="<?php echo e(route('products.show', $relatedProduct->slug)); ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
        fetch('<?php echo e(route('cart.count')); ?>')
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bagxidvn/public_html/resources/views/frontend/products/show.blade.php ENDPATH**/ ?>
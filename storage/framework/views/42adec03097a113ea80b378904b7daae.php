<?php $__env->startSection('title', 'Giỏ hàng'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Trang chủ</a></li>
            <li class="breadcrumb-item active">Giỏ hàng</li>
        </ol>
    </nav>

    <h2 class="mb-4">Giỏ hàng của bạn</h2>

    <?php if(empty($cartItems)): ?>
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
            <h5>Giỏ hàng của bạn đang trống</h5>
            <p class="text-muted">Hãy thêm một số sản phẩm vào giỏ hàng để tiếp tục mua sắm</p>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary">
                <i class="fas fa-shopping-bag me-2"></i>Tiếp tục mua sắm
            </a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Tổng</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-variant-id="<?php echo e($id); ?>">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if($item['variant']->product->main_image): ?>
                                                    <!-- Fixed image display to use product main image -->
                                                    <img src="<?php echo e(asset($item['variant']->product->main_image->img_url)); ?>" 
                                                         class="me-3" style="width: 60px; height: 60px; object-fit: cover;" 
                                                         alt="<?php echo e($item['variant']->product->name); ?>">
                                                <?php else: ?>
                                                    <img src="/placeholder.svg?height=60&width=60" 
                                                         class="me-3" style="width: 60px; height: 60px; object-fit: cover;" 
                                                         alt="<?php echo e($item['variant']->product->name); ?>">
                                                <?php endif; ?>
                                                <div>
                                                    <h6 class="mb-1"><?php echo e($item['variant']->product->name); ?></h6>
                                                    <small class="text-muted"><?php echo e($item['variant']->option); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <span class="price-text"><?php echo e(number_format($item['price'])); ?>đ</span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="input-group" style="max-width: 120px;">
                                                <button type="button" class="btn btn-outline-secondary btn-sm decrease-qty">-</button>
                                                <input type="number" class="form-control form-control-sm text-center quantity-input" 
                                                       value="<?php echo e($item['quantity']); ?>" min="1" max="<?php echo e($item['variant']->stock); ?>">
                                                <button type="button" class="btn btn-outline-secondary btn-sm increase-qty">+</button>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <span class="fw-bold subtotal"><?php echo e(number_format($item['subtotal'])); ?>đ</span>
                                        </td>
                                        <td class="align-middle">
                                            <button type="button" class="btn btn-outline-danger btn-sm remove-item">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-3">
                            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
                            </a>
                            <form method="POST" action="<?php echo e(route('cart.clear')); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-outline-danger" 
                                        onclick="return confirm('Bạn có chắc muốn xóa tất cả sản phẩm?')">
                                    <i class="fas fa-trash me-2"></i>Xóa tất cả
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Tóm tắt đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Tạm tính:</span>
                            <span id="cart-total"><?php echo e(number_format($total)); ?>đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Phí vận chuyển:</span>
                            <span class="text-success">Miễn phí</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Tổng cộng:</strong>
                            <strong class="price-text" id="final-total"><?php echo e(number_format($total)); ?>đ</strong>
                        </div>
                        
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('checkout.index')); ?>" class="btn btn-primary w-100 btn-lg">
                                <i class="fas fa-credit-card me-2"></i>Thanh toán
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="btn btn-primary w-100 btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập để thanh toán
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update quantity
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            updateCartItem(this.closest('tr').dataset.variantId, this.value);
        });
    });

    // Increase/Decrease quantity buttons
    document.querySelectorAll('.increase-qty').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const max = parseInt(input.max);
            const current = parseInt(input.value);
            if (current < max) {
                input.value = current + 1;
                updateCartItem(this.closest('tr').dataset.variantId, input.value);
            }
        });
    });

    document.querySelectorAll('.decrease-qty').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.nextElementSibling;
            const current = parseInt(input.value);
            if (current > 1) {
                input.value = current - 1;
                updateCartItem(this.closest('tr').dataset.variantId, input.value);
            }
        });
    });

    // Remove item
    document.querySelectorAll('.remove-item').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
                removeCartItem(this.closest('tr').dataset.variantId);
            }
        });
    });

    function updateCartItem(variantId, quantity) {
        fetch('<?php echo e(route("cart.update")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                variant_id: variantId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update subtotal
                const row = document.querySelector(`tr[data-variant-id="${variantId}"]`);
                row.querySelector('.subtotal').textContent = data.subtotal + 'đ';
                
                // Update totals
                document.getElementById('cart-total').textContent = data.total + 'đ';
                document.getElementById('final-total').textContent = data.total + 'đ';
                
                // Update cart count in navbar
                updateCartCount();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra, vui lòng thử lại!');
        });
    }

    function removeCartItem(variantId) {
        fetch('<?php echo e(route("cart.remove")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                variant_id: variantId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove row
                document.querySelector(`tr[data-variant-id="${variantId}"]`).remove();
                
                // Update totals
                document.getElementById('cart-total').textContent = data.total + 'đ';
                document.getElementById('final-total').textContent = data.total + 'đ';
                
                // Update cart count in navbar
                updateCartCount();
                
                // Check if cart is empty
                if (document.querySelectorAll('tbody tr').length === 0) {
                    location.reload();
                }
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra, vui lòng thử lại!');
        });
    }

    function updateCartCount() {
        fetch('<?php echo e(route("cart.count")); ?>')
        .then(response => response.json())
        .then(data => {
            const badge = document.querySelector('.navbar .badge');
            if (badge) {
                badge.textContent = data.count;
            }
        });
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bagxidvn/public_html/resources/views/frontend/cart/index.blade.php ENDPATH**/ ?>
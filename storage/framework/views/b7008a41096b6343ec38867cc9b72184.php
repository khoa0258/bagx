

<?php $__env->startSection('title', 'Thanh toán'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('cart.index')); ?>">Giỏ hàng</a></li>
            <li class="breadcrumb-item active">Thanh toán</li>
        </ol>
    </nav>

    <h2 class="mb-4">Thanh toán</h2>

    <form method="POST" action="<?php echo e(route('checkout.store')); ?>" id="checkout-form">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-lg-8">
                <!-- Shipping Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-shipping-fast me-2"></i>Thông tin giao hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">Họ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="first_name" name="first_name" value="<?php echo e(old('first_name', $user->first_name ?? '')); ?>" 
                                       tabindex="1" required>
                                <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="last_name" name="last_name" value="<?php echo e(old('last_name', $user->last_name ?? '')); ?>" 
                                       tabindex="2" required>
                                <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="email" name="email" value="<?php echo e(old('email', $user->email ?? '')); ?>" 
                                   tabindex="3" required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="phone" name="phone" value="<?php echo e(old('phone', $user->phone ?? '')); ?>" 
                                   tabindex="4" required autofocus>
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                            <textarea class="form-control <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      id="shipping_address" name="shipping_address" rows="3" 
                                      tabindex="5" required><?php echo e(old('shipping_address', $user->address ?? '')); ?></textarea>
                            <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="note" class="form-label">Ghi chú đơn hàng</label>
                            <textarea class="form-control <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      id="note" name="note" rows="2" tabindex="6" 
                                      placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn."><?php echo e(old('note')); ?></textarea>
                            <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Phương thức thanh toán</h5>
                    </div>
                    <div class="card-body">
                        <?php if($payments->isEmpty()): ?>
                            <div class="alert alert-warning" role="alert">
                                Hiện tại không có phương thức thanh toán nào khả dụng. Vui lòng liên hệ quản trị viên.
                            </div>
                        <?php else: ?>
                            <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-check mb-3">
                                <input class="form-check-input <?php $__errorArgs = ['id_payment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       type="radio" name="id_payment" id="payment_<?php echo e($payment->id); ?>" 
                                       value="<?php echo e($payment->id); ?>" <?php echo e(old('id_payment', 1) == $payment->id ? 'checked' : ''); ?> 
                                       tabindex="7" required>
                                <label class="form-check-label" for="payment_<?php echo e($payment->id); ?>">
                                    <strong><?php echo e($payment->name); ?></strong>
                                    <?php if($payment->description): ?>
                                        <br><small class="text-muted"><?php echo e($payment->description); ?></small>
                                    <?php endif; ?>
                                </label>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__errorArgs = ['id_payment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Order Summary -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Đơn hàng của bạn</h5>
                    </div>
                    <div class="card-body">
                        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-1"><?php echo e($item['variant']->product->name); ?></h6>
                                <small class="text-muted"><?php echo e($item['variant']->option); ?> × <?php echo e($item['quantity']); ?></small>
                            </div>
                            <span class="fw-bold"><?php echo e(number_format($item['subtotal'], 0, ',', '.')); ?>đ</span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tạm tính:</span>
                            <span><?php echo e(number_format($total, 0, ',', '.')); ?>đ</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span>Phí vận chuyển:</span>
                            <span class="text-success">Miễn phí</span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Tổng cộng:</strong>
                            <strong class="price-text"><?php echo e(number_format($total, 0, ',', '.')); ?>đ</strong>
                        </div>
                        
                        <!-- Nút Đặt hàng thông thường -->
                        <button type="submit" name="payment_type" value="cod" class="btn btn-primary w-100 btn-lg mb-2" tabindex="8">
                            <i class="fas fa-check me-2"></i>Đặt hàng
                        </button>
                        
                        <!-- Nút Thanh toán VNPAY -->
                        <button type="submit" name="payment_type" value="vnpay" class="btn btn-success w-100 btn-lg" tabindex="9">
                            <i class="fas fa-credit-card me-2"></i>Thanh toán VNPAY
                        </button>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                Bằng việc đặt hàng, bạn đồng ý với 
                                <a href="#" class="text-decoration-none">Điều khoản sử dụng</a> của chúng tôi.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- JavaScript để xử lý form -->
   <script>
document.getElementById('checkout-form').addEventListener('submit', function(event) {
    const paymentType = event.submitter.value;  // Xác định phương thức thanh toán
    const firstName = document.getElementById('first_name').value.trim();
    const lastName = document.getElementById('last_name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const shippingAddress = document.getElementById('shipping_address').value.trim();
    const paymentMethod = document.querySelector('input[name="id_payment"]:checked'); // Lấy phương thức thanh toán đã chọn

    // Validate các trường
    if (!firstName) {
        event.preventDefault();
        alert('Vui lòng nhập họ!');
        document.getElementById('first_name').focus();
        return false;
    }

    if (!lastName) {
        event.preventDefault();
        alert('Vui lòng nhập tên!');
        document.getElementById('last_name').focus();
        return false;
    }

    if (!email) {
        event.preventDefault();
        alert('Vui lòng nhập email!');
        document.getElementById('email').focus();
        return false;
    }

    if (!phone) {
        event.preventDefault();
        alert('Vui lòng nhập số điện thoại!');
        document.getElementById('phone').focus();
        return false;
    }

    if (!shippingAddress) {
        event.preventDefault();
        alert('Vui lòng nhập địa chỉ giao hàng!');
        document.getElementById('shipping_address').focus();
        return false;
    }

    if (!paymentMethod) {
        event.preventDefault();
        alert('Vui lòng chọn phương thức thanh toán!');
        document.getElementById('payment_1').focus();
        return false;
    }

    // Ngừng gửi form để xử lý thanh toán
    event.preventDefault();

    const formData = new FormData(this);  // Thu thập dữ liệu form
    formData.append('total_vnpay', '<?php echo e($total); ?>');  // Thêm tổng số tiền vào formData
    formData.append('payment_type', paymentType);  // Thêm loại thanh toán

    // Gửi request POST cho thanh toán VNPAY
    fetch('<?php echo e(route('checkout.store')); ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'  // Gửi CSRF token để bảo mật
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.redirect) {
            // Nếu có URL redirect, thực hiện chuyển hướng người dùng
            window.location.href = data.redirect;  // Chuyển hướng tới trang VNPAY hoặc success
        } else {
            alert('Lỗi thanh toán VNPAY: ' + (data.message || 'Có lỗi xảy ra!'));
        }
    })
    .catch(error => {
        alert('Có lỗi xảy ra khi thanh toán VNPAY!');
        console.error(error);
    });
});
</script>


</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bagxidvn/public_html/resources/views/frontend/checkout/index.blade.php ENDPATH**/ ?>
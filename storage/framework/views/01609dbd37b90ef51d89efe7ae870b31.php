<?php $__env->startSection('title', 'Đơn hàng của tôi'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Trang chủ</a></li>
            <li class="breadcrumb-item active">Đơn hàng của tôi</li>
        </ol>
    </nav>

    <h2 class="mb-4">Đơn hàng của tôi</h2>

    <?php if($orders->count() > 0): ?>
        <div class="row">
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Đơn hàng #<?php echo e($order->id); ?></h6>
                                <small class="text-muted"><?php echo e($order->formatted_order_date); ?></small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-<?php echo e($order->status == 3 ? 'success' : ($order->status == 0 ? 'danger' : 'warning')); ?> mb-1">
                                    <?php echo e($order->status_text); ?>

                                </span>
                                <br>
                                <span class="badge bg-<?php echo e($order->thanh_toan ? 'success' : 'secondary'); ?>">
                                    <?php echo e($order->payment_status_text); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h6>Sản phẩm:</h6>
                                <?php $__currentLoopData = $order->orderDetails->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="flex-grow-1">
                                            <span><?php echo e($detail->variant && $detail->variant->product ? $detail->variant->product->name . ' - ' . $detail->variant->option : 'Sản phẩm không tồn tại'); ?></span>
                                            <small class="text-muted"> × <?php echo e($detail->quantity); ?></small>
                                        </div>
                                        <!-- <span><?php echo e(number_format($detail->price * $detail->quantity)); ?>đ</span> -->
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if($order->orderDetails->count() > 3): ?>
                                    <small class="text-muted">và <?php echo e($order->orderDetails->count() - 3); ?> sản phẩm khác...</small>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="mb-3">
                                    <strong class="price-text">Tổng: <?php echo e(number_format($order->total_price)); ?>đ</strong>
                                </div>
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>Chi tiết
                                    </a>
                                    <?php if($order->status == 1): ?>
                                        <form method="POST" action="<?php echo e(route('orders.cancel', $order->id)); ?>" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                    onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                                                <i class="fas fa-times me-1"></i>Hủy
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <?php if(in_array($order->status, [0, 3])): ?>
                                        <form method="POST" action="<?php echo e(route('orders.reorder', $order->id)); ?>" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-outline-success btn-sm" 
                                                    onclick="return confirm('Bạn có muốn đặt lại đơn hàng này?')">
                                                <i class="fas fa-redo me-1"></i>Đặt lại
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
        <!-- <div class="d-flex justify-content-center">
            <?php echo e($orders->links()); ?>

        </div> -->
    <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
            <h5>Bạn chưa có đơn hàng nào</h5>
            <p class="text-muted">Hãy bắt đầu mua sắm để tạo đơn hàng đầu tiên</p>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary">
                <i class="fas fa-shopping-bag me-2"></i>Bắt đầu mua sắm
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bagxidvn/public_html/resources/views/frontend/orders/index.blade.php ENDPATH**/ ?>
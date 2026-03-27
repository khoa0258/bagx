

<?php $__env->startSection('title', 'Chi tiết đơn hàng #' . $order->id); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('orders.index')); ?>">Đơn hàng của tôi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Đơn hàng #<?php echo e($order->id); ?></li>
        </ol>
    </nav>

    <h2 class="mb-4">Chi tiết đơn hàng #<?php echo e($order->id); ?></h2>

    <div class="row">
        <!-- Thông tin đơn hàng -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Mã đơn hàng:</strong> #<?php echo e($order->id); ?></p>
                            <p><strong>Ngày đặt:</strong> <?php echo e($order->formatted_order_date); ?></p>
                            <p><strong>Trạng thái:</strong> 
                                <span class="badge bg-<?php echo e($order->status == 3 ? 'success' : ($order->status == 0 ? 'danger' : ($order->status == 2 ? 'info' : 'warning'))); ?>">
                                    <?php echo e($order->status_text); ?>

                                </span>
                            </p>
                            <p><strong>Thanh toán:</strong> 
                                <span class="badge bg-<?php echo e($order->thanh_toan ? 'success' : 'secondary'); ?>">
                                    <?php echo e($order->payment_status_text); ?>

                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Phương thức thanh toán:</strong> <?php echo e($order->payment ? $order->payment->name : 'Không xác định'); ?></p>
                            <p><strong>Ghi chú:</strong> <?php echo e($order->note ?? 'Không có ghi chú'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sản phẩm trong đơn hàng -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Sản phẩm trong đơn hàng</h5>
                </div>
                <div class="card-body">
                    <?php if($order->orderDetails->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Biến thể</th>
                                        <th>Số lượng</th>
                                        <th>Đơn giá</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $order->orderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <?php if($detail->variant && $detail->variant->product): ?>
                                                    <?php echo e($detail->variant->product->name); ?>

                                                <?php else: ?>
                                                    Sản phẩm không tồn tại
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($detail->variant ? $detail->variant->option : 'Không có'); ?></td>
                                            <td><?php echo e($detail->quantity); ?></td>
                                            <td><?php echo e(number_format($detail->price)); ?>đ</td>
                                            <td><?php echo e(number_format($detail->price * $detail->quantity)); ?>đ</td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end">
                            <h5>Tổng cộng: <strong><?php echo e(number_format($order->total_price)); ?>đ</strong></h5>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Không có sản phẩm trong đơn hàng.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Thông tin khách hàng và giao hàng -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin khách hàng</h5>
                </div>
                <div class="card-body">
                    <p><strong>Họ và tên:</strong> <?php echo e($order->user ? $order->user->last_name . ' ' . $order->user->first_name : 'Không xác định'); ?></p>
                    <p><strong>Email:</strong> <?php echo e($order->user ? $order->user->email : 'Không xác định'); ?></p>
                    <p><strong>Số điện thoại:</strong> <?php echo e($order->phone); ?></p>
                    <p><strong>Địa chỉ giao hàng:</strong> <?php echo e($order->address); ?></p>
                </div>
            </div>

            <!-- Nút hành động -->
            <div class="card">
                <div class="card-body text-center">
                    <div class="btn-group" role="group">
                        <?php if($order->status == 1): ?>
                            <form method="POST" action="<?php echo e(route('orders.cancel', $order->id)); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-outline-danger btn-sm" 
                                        onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                                    <i class="fas fa-times me-1"></i>Hủy đơn hàng
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
                        <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bagxidvn/public_html/resources/views/frontend/orders/show.blade.php ENDPATH**/ ?>
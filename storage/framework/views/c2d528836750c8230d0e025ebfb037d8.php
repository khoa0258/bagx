<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Stats Cards -->
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo e(number_format($stats['total_products'])); ?></h4>
                        <p class="mb-0">Sản phẩm</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo e(number_format($stats['total_orders'])); ?></h4>
                        <p class="mb-0">Đơn hàng</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo e(number_format($stats['pending_orders'])); ?></h4>
                        <p class="mb-0">Đơn chờ xử lý</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo e(number_format($stats['total_revenue'])); ?>đ</h4>
                        <p class="mb-0">Doanh thu</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-dollar-sign fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
    <div class="card bg-danger text-white">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4><?php echo e(number_format($stats['total_revenue_vnpay'])); ?>đ</h4>
                    <p class="mb-0">Đã thanh toán qua VNPAY</p>
                    <!--<small><?php echo e(number_format($stats['vnpay_orders_count'])); ?> đơn</small>-->
                </div>
                <div class="align-self-center">
                    <i class="fas fa-receipt fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-3 mb-4">
    <div class="card bg-secondary text-white">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4><?php echo e(number_format($stats['total_revenue_cod'])); ?>đ</h4>
                    <p class="mb-0">Thanh toán khi nhận hàng</p>
                    <!--<small><?php echo e(number_format($stats['cod_orders_count'])); ?> đơn</small>-->
                </div>
                <div class="align-self-center">
                    <i class="fas fa-truck fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Recent Orders -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Đơn hàng gần đây</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $recent_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>#<?php echo e($order->id); ?></td>
                        <td><?php echo e($order->user ? $order->user->full_name : 'Khách vãng lai'); ?></td>
                        <td><?php echo e(number_format($order->total_price)); ?>đ</td>
                        <td>
                            <span class="badge bg-<?php echo e($order->status == 3 ? 'success' : ($order->status == 0 ? 'danger' : 'warning')); ?>">
                                <?php echo e($order->status_text); ?>

                            </span>
                        </td>
                        <td><?php echo e($order->formatted_created_at); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-sm btn-outline-primary">
                                Xem
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center">Chưa có đơn hàng nào</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bagxidvn/public_html/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>
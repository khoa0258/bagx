<?php $__env->startSection('title', 'Quản lý đơn hàng'); ?>
<?php $__env->startSection('page-title', 'Quản lý đơn hàng'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Danh sách đơn hàng</h4>
    
    <!-- Filter Form -->
    <form method="GET" action="<?php echo e(route('admin.orders.index')); ?>" class="d-flex gap-2">
        <select class="form-select" name="status" style="width: auto;">
            <option value="">Tất cả trạng thái</option>
            <option value="0" <?php echo e(request('status') == '0' ? 'selected' : ''); ?>>Đã hủy</option>
            <option value="1" <?php echo e(request('status') == '1' ? 'selected' : ''); ?>>Đang xử lý</option>
            <option value="2" <?php echo e(request('status') == '2' ? 'selected' : ''); ?>>Đang giao</option>
            <option value="3" <?php echo e(request('status') == '3' ? 'selected' : ''); ?>>Hoàn thành</option>
        </select>
        <select class="form-select" name="thanh_toan" style="width: auto;">
            <option value="">Tất cả thanh toán</option>
            <option value="0" <?php echo e(request('thanh_toan') == '0' ? 'selected' : ''); ?>>Chưa thanh toán</option>
            <option value="1" <?php echo e(request('thanh_toan') == '1' ? 'selected' : ''); ?>>Đã thanh toán</option>
        </select>
        <button type="submit" class="btn btn-outline-primary">Lọc</button>
    </form>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
           <table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Số điện thoại</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Thanh toán</th>
            <th>Ngày đặt</th>
            <!-- <th>Thao tác</th> -->
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>#<?php echo e($order->id); ?></td>
<td><?php echo e(optional($order->user)->full_name ?? ($order->name ?? 'Không có tên')); ?></td>
                <td class="fw-bold text-primary"><?php echo e(number_format($order->total_price)); ?>đ</td>
                <td>
                    <span class="badge bg-<?php echo e($order->status == 3 ? 'success' : ($order->status == 0 ? 'danger' : 'warning')); ?>">
                        <?php echo e($order->status_text); ?>

                    </span>
                </td>
                <td>
                    <span class="badge bg-<?php echo e($order->thanh_toan ? 'success' : 'secondary'); ?>">
                        <?php echo e($order->payment_status_text); ?>

                    </span>
                </td>
                <td><?php echo e($order->formatted_order_date); ?></td>
                <td>
                    <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i> Xem
                    </a>
                    <!-- chức năng xoá đơn hàng -->
                    <!-- <form action="<?php echo e(route('admin.orders.destroy', $order)); ?>" method="POST" class="d-inline" 
                          onsubmit="return confirm('Bạn có chắc muốn xóa đơn hàng này?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </form> -->
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8" class="text-center">Chưa có đơn hàng nào</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
        </div>

        <!-- Pagination -->
        <!-- <div class="d-flex justify-content-center">
            <?php echo e($orders->appends(request()->query())->links()); ?>

        </div> -->
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bagxidvn/public_html/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>
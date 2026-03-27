<?php $__env->startSection('title', 'Chi tiết đơn hàng #' . $order->id); ?>
<?php $__env->startSection('page-title', 'Chi tiết đơn hàng #' . $order->id); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8">
        <!-- Order Details -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Thông tin đơn hàng</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Thông tin khách hàng</h6>
                        <p class="mb-1"><strong>Tên:</strong> <?php echo e($order->user ? $order->user->full_name : ($order->name ?? 'Không có tên')); ?></p>
                        <p class="mb-1"><strong>Email:</strong> <?php echo e($order->user ? $order->user->email : 'N/A'); ?></p>
                        <p class="mb-1"><strong>Điện thoại:</strong> <?php echo e($order->phone ?? 'N/A'); ?></p>
                        <p class="mb-1"><strong>Địa chỉ:</strong> <?php echo e($order->address ?? 'N/A'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Thông tin đơn hàng</h6>
                        <p class="mb-1"><strong>Mã đơn:</strong> #<?php echo e($order->id); ?></p>
                        <p class="mb-1"><strong>Ngày đặt:</strong> <?php echo e($order->formatted_order_date); ?></p>
                        <p class="mb-1"><strong>Phương thức thanh toán:</strong> <?php echo e($order->payment ? $order->payment->name : 'N/A'); ?></p>
                        <p class="mb-1"><strong>Tổng tiền:</strong> <span class="text-primary fw-bold"><?php echo e(number_format($order->total_price)); ?>đ</span></p>
                    </div>
                </div>
                
                <?php if($order->note): ?>
                    <div class="mt-3">
                        <h6>Ghi chú</h6>
                        <p class="text-muted"><?php echo e($order->note); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Sản phẩm đã đặt</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $order->orderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div>
                                        <h6 class="mb-1"><?php echo e($detail->variant && $detail->variant->product ? $detail->variant->product->name : 'Sản phẩm không tồn tại'); ?></h6>
                                        <small class="text-muted"><?php echo e($detail->variant ? $detail->variant->option : 'N/A'); ?></small>
                                    </div>
                                </td>
                                <td><?php echo e(number_format($detail->price)); ?>đ</td>
                                <td><?php echo e($detail->quantity); ?></td>
                                <td><strong><?php echo e(number_format($detail->total)); ?>đ</strong></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Tổng cộng:</th>
                                <th class="text-primary"><?php echo e(number_format($order->total_price)); ?>đ</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Order Status -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Cập nhật trạng thái</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('admin.orders.update-status', $order)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Trạng thái đơn hàng</label>
                        <select class="form-select" name="status" <?php echo e(in_array($order->status, [0, 3]) ? 'disabled' : ''); ?>>
                            <?php if($order->status == 1): ?>
                                <option value="2" selected>Đang giao</option>
                            <?php elseif($order->status == 2): ?>
                                <option value="3" selected>Hoàn thành</option>
                            <?php else: ?>
                                <option value="<?php echo e($order->status); ?>" selected><?php echo e($order->status_text); ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <?php if(!in_array($order->status, [0, 3])): ?>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save"></i> Cập nhật trạng thái
                        </button>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Payment Status -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Trạng thái thanh toán</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('admin.orders.update-payment', $order)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Thanh toán</label>
                        <select class="form-select" name="thanh_toan">
                            <option value="0" <?php echo e($order->thanh_toan == 0 ? 'selected' : ''); ?>>Chưa thanh toán</option>
                            <option value="1" <?php echo e($order->thanh_toan == 1 ? 'selected' : ''); ?>>Đã thanh toán</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-credit-card"></i> Cập nhật thanh toán
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Quay lại danh sách
    </a>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bagxidvn/public_html/resources/views/admin/orders/show.blade.php ENDPATH**/ ?>
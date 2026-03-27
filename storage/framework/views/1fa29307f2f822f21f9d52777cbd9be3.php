

<?php $__env->startSection('title', 'Chi tiết User'); ?>
<?php $__env->startSection('page-title', 'Chi tiết User'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Thông tin User: <?php echo e($user->full_name); ?></h4>
        <div class="row">
            <div class="col-md-6">
                <p><strong>ID:</strong> <?php echo e($user->id); ?></p>
                <p><strong>Tên đầy đủ:</strong> <?php echo e($user->full_name); ?></p>
                <p><strong>Email:</strong> <?php echo e($user->email); ?></p>
                <p><strong>Số điện thoại:</strong> <?php echo e($user->phone); ?></p>
                <p><strong>Địa chỉ:</strong> <?php echo e($user->address ?? 'N/A'); ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Vai trò:</strong> <?php echo e($user->roles == 2 ? 'Admin' : 'User'); ?></p>
                <p><strong>Trạng thái:</strong> 
                    <span class="badge bg-<?php echo e($user->account_lock ? 'success' : 'danger'); ?>">
                        <?php echo e($user->account_lock ? 'Hoạt động' : 'Khóa'); ?>

                    </span>
                </p>
                <p><strong>Ngày tạo:</strong> <?php echo e($user->created_at->format('d/m/Y H:i')); ?></p>
                <p><strong>Ngày cập nhật:</strong> <?php echo e($user->updated_at->format('d/m/Y H:i')); ?></p>
            </div>
        </div>
        <div class="mt-4">
            <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn-primary">
                <i class="fas fa-edit"></i> Chỉnh sửa
            </a>
            <form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>" 
                  class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Xóa
                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bagxidvn/public_html/resources/views/admin/users/show.blade.php ENDPATH**/ ?>
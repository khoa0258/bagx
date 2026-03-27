<?php $__env->startSection('title', 'Quản lý danh mục'); ?>
<?php $__env->startSection('page-title', 'Quản lý danh mục'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Danh sách danh mục</h4>
    <div class="btn-group" role="group">
        <a href="<?php echo e(route('admin.categories.create-main')); ?>" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm danh mục chính
        </a>
        <a href="<?php echo e(route('admin.categories.create-sub')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm danh mục con
        </a>
    </div>
</div>

<!-- Main Categories -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Danh mục chính</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Số danh mục con</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $mainCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($category->id); ?></td>
                        <td><?php echo e($category->name); ?></td>
                        <td><?php echo e($category->subCategories->count()); ?></td>
                        <td><?php echo e($category->created_at ? $category->created_at->format('d/m/Y') : 'N/A'); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="text-center">Chưa có danh mục chính nào</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Sub Categories -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Danh mục con</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Danh mục chính</th>
                        <th>Trạng thái</th>
                        <th>Thứ tự</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($category->id); ?></td>
                        <td><?php echo e($category->name); ?></td>
                        <td><?php echo e($category->mainCategory->name ?? 'N/A'); ?></td>
                        <td>
                            <span class="badge bg-<?php echo e($category->status ? 'success' : 'danger'); ?>">
                                <?php echo e($category->status ? 'Hoạt động' : 'Ẩn'); ?>

                            </span>
                        </td>
                        <td><?php echo e($category->sort ?? 0); ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="<?php echo e(route('admin.categories.destroy', $category)); ?>" 
                                      class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center">Chưa có danh mục con nào</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <!-- <div class="d-flex justify-content-center">
            <?php echo e($subCategories->links()); ?>

        </div> -->
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bagxidvn/public_html/resources/views/admin/categories/index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Quản lý sản phẩm'); ?>
<?php $__env->startSection('page-title', 'Quản lý sản phẩm'); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Danh sách sản phẩm</h4>
    <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm sản phẩm
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Thương hiệu</th>
                        <th>Giá</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($product->id); ?></td>
                        <td><?php echo e($product->name); ?></td>
                        <td><?php echo e($product->category->name ?? 'N/A'); ?></td>
                        <td><?php echo e($product->brand->name ?? 'N/A'); ?></td>
                        <td>
                            <?php if($product->variants->count() > 0): ?>
                                <?php echo e(number_format($product->min_price)); ?>đ
                                <?php if($product->min_price != $product->max_price): ?>
                                    - <?php echo e(number_format($product->max_price)); ?>đ
                                <?php endif; ?>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge bg-<?php echo e($product->status ? 'success' : 'danger'); ?>">
                                <?php echo e($product->status ? 'Hoạt động' : 'Ẩn'); ?>

                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <!--<a href="<?php echo e(route('admin.products.show', $product)); ?>" -->
                                <!--   class="btn btn-sm btn-outline-info">-->
                                <!--    <i class="fas fa-eye"></i>-->
                                <!--</a>-->
                                <a href="<?php echo e(route('admin.products.edit', $product)); ?>" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="<?php echo e(route('admin.products.destroy', $product)); ?>" 
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
                        <td colspan="7" class="text-center">Chưa có sản phẩm nào</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- <div class="d-flex justify-content-center">
            <?php echo e($products->links()); ?>

        </div> -->
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bagxidvn/public_html/resources/views/admin/products/index.blade.php ENDPATH**/ ?>
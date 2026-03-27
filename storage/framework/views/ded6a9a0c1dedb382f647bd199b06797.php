<?php $__env->startSection('title', 'Sản phẩm'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Trang chủ</a></li>
            <li class="breadcrumb-item active">Sản phẩm</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-filter me-2"></i>Bộ lọc</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="<?php echo e(route('products.index')); ?>">
                        <!-- Search -->
                        <div class="mb-3">
                            <label class="form-label">Tìm kiếm</label>
                            <input type="text" class="form-control" name="search" 
                                   value="<?php echo e(request('search')); ?>" placeholder="Nhập tên sản phẩm...">
                        </div>

                        <!-- Category Filter -->
                        <div class="mb-3">
                            <label class="form-label">Danh mục</label>
                            <select class="form-select" name="category">
                                <option value="">Tất cả danh mục</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" 
                                            <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->mainCategory->name); ?> - <?php echo e($category->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Brand Filter -->
                        <div class="mb-3">
                            <label class="form-label">Thương hiệu</label>
                            <select class="form-select" name="brand">
                                <option value="">Tất cả thương hiệu</option>
                                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($brand->id); ?>" 
                                            <?php echo e(request('brand') == $brand->id ? 'selected' : ''); ?>>
                                        <?php echo e($brand->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Sort -->
                        <div class="mb-3">
                            <label class="form-label">Sắp xếp</label>
                            <select class="form-select" name="sort">
                                <option value="">Mặc định</option>
                                <option value="newest" <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>>Mới nhất</option>
                                <option value="popular" <?php echo e(request('sort') == 'popular' ? 'selected' : ''); ?>>Phổ biến</option>
                                <option value="price_asc" <?php echo e(request('sort') == 'price_asc' ? 'selected' : ''); ?>>Giá thấp đến cao</option>
                                <option value="price_desc" <?php echo e(request('sort') == 'price_desc' ? 'selected' : ''); ?>>Giá cao đến thấp</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Lọc sản phẩm
                        </button>
                        
                        <?php if(request()->hasAny(['search', 'category', 'brand', 'sort'])): ?>
                            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-secondary w-100 mt-2">
                                <i class="fas fa-times me-2"></i>Xóa bộ lọc
                            </a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <!-- Results Info -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>Sản phẩm</h4>
                <span class="text-muted">Hiển thị <?php echo e($products->count()); ?> trong <?php echo e($products->total()); ?> sản phẩm</span>
            </div>

            <?php if($products->count() > 0): ?>
                <div class="row g-4">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 col-xl-4">
                        <div class="card product-card h-100">
                            <div class="position-relative">
                                <?php if($product->main_image): ?>
                                    <!-- Fixed image URL from img_products to img_url -->
                                    <img src="<?php echo e(asset($product->main_image->img_url)); ?>" 
                                         class="card-img-top product-image" alt="<?php echo e($product->name); ?>">
                                <?php else: ?>
                                    <img src="/placeholder.svg?height=250&width=300" 
                                         class="card-img-top product-image" alt="<?php echo e($product->name); ?>">
                                <?php endif; ?>
                                <?php if($product->discount): ?>
                                    <span class="position-absolute top-0 start-0 badge bg-danger m-2">
                                        -<?php echo e($product->discount->value); ?><?php echo e($product->discount->type == 'percent' ? '%' : 'đ'); ?>

                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title"><?php echo e($product->name); ?></h6>
                                <p class="text-muted small mb-2">
                                    <?php echo e($product->category->name ?? 'N/A'); ?> • <?php echo e($product->brand->name ?? 'N/A'); ?>

                                </p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="price-text">
                                            <?php if($product->variants->count() > 0): ?>
                                                <?php echo e(number_format($product->min_price)); ?>đ
                                                <?php if($product->min_price != $product->max_price): ?>
                                                    - <?php echo e(number_format($product->max_price)); ?>đ
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </span>
                                        <small class="text-muted">
                                            <i class="fas fa-eye me-1"></i><?php echo e($product->views); ?>

                                        </small>
                                    </div>
                                    <a href="<?php echo e(route('products.show', $product->slug)); ?>" 
                                       class="btn btn-primary w-100">
                                        <i class="fas fa-eye me-2"></i>Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    <?php echo e($products->appends(request()->query())->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h5>Không tìm thấy sản phẩm nào</h5>
                    <p class="text-muted">Hãy thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
                    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary">
                        Xem tất cả sản phẩm
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bagxidvn/public_html/resources/views/frontend/products/index.blade.php ENDPATH**/ ?>
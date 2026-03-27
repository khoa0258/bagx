<?php $__env->startSection('title', 'Trang chủ'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->

    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
                <img src="<?php echo e(asset('storage/img/banner_balo.png')); ?>" alt="Banner_balo" class="img-fluid">
    </div>
    <!-- <div class="carousel-item">
      <img src="..." class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="..." class="d-block w-100" alt="...">
    </div> -->
  </div>
</div>


<!-- Brands Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Các thương hiệu nổi tiếng</h2>
            <p class="text-muted">Khám phá các thương hiệu yêu thích của bạn</p>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 col-lg-2">
                <div class="card brand-card h-100 text-center border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <?php if($brand->logo): ?>
                                <img src="<?php echo e(asset('storage/' . $brand->logo)); ?>" alt="<?php echo e($brand->name); ?>" style="max-width: 100px; max-height: 50px;">
                            <?php else: ?>
                                <i class="fas fa-tags fa-3x text-primary"></i>
                            <?php endif; ?>
                        </div>
                        <h6 class="card-title"><?php echo e($brand->name); ?></h6>
                        
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Sản phẩm nổi bật</h2>
            <p class="text-muted">Những sản phẩm được yêu thích nhất</p>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-3">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        <?php if($product->main_image): ?>
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
                        <p class="text-muted small mb-2"><?php echo e($product->category->name ?? 'N/A'); ?></p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-text">
                                    <?php if($product->variants->count() > 0): ?>
                                        <?php echo e(number_format($product->min_price)); ?>đ
                                        <?php if($product->min_price != $product->max_price): ?>
                                            - <?php echo e(number_format($product->max_price)); ?>đ
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </span>
                                <a href="<?php echo e(route('products.show', $product->slug)); ?>" 
                                   class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-primary">
                Xem tất cả sản phẩm <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- New Products -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Sản phẩm mới</h2>
            <p class="text-muted">Những sản phẩm mới nhất vừa được cập nhật</p>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $newProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-3">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        <?php if($product->main_image): ?>
                            <img src="<?php echo e(asset($product->main_image->img_url)); ?>" 
                                 class="card-img-top product-image" alt="<?php echo e($product->name); ?>">
                        <?php else: ?>
                            <img src="/placeholder.svg?height=250&width=300" 
                                 class="card-img-top product-image" alt="<?php echo e($product->name); ?>">
                        <?php endif; ?>
                        <span class="position-absolute top-0 end-0 badge bg-success m-2">Mới</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title"><?php echo e($product->name); ?></h6>
                        <p class="text-muted small mb-2"><?php echo e($product->category->name ?? 'N/A'); ?></p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-text">
                                    <?php if($product->variants->count() > 0): ?>
                                        <?php echo e(number_format($product->min_price)); ?>đ
                                        <?php if($product->min_price != $product->max_price): ?>
                                            - <?php echo e(number_format($product->max_price)); ?>đ
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </span>
                                <a href="<?php echo e(route('products.show', $product->slug)); ?>" 
                                   class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-3">
                <div class="mb-3">
                    <i class="fas fa-shipping-fast fa-3x"></i>
                </div>
                <h5>Giao hàng nhanh</h5>
                <p class="mb-0">Giao hàng trong 24h tại TP.HCM</p>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <i class="fas fa-undo fa-3x"></i>
                </div>
                <h5>Đổi trả dễ dàng</h5>
                <p class="mb-0">Đổi trả trong 7 ngày không cần lý do</p>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <i class="fas fa-shield-alt fa-3x"></i>
                </div>
                <h5>Bảo hành chính hãng</h5>
                <p class="mb-0">Cam kết sản phẩm chính hãng 100%</p>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <i class="fas fa-headset fa-3x"></i>
                </div>
                <h5>Hỗ trợ 24/7</h5>
                <p class="mb-0">Đội ngũ tư vấn nhiệt tình, chuyên nghiệp</p>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bagxidvn/public_html/resources/views/frontend/home.blade.php ENDPATH**/ ?>
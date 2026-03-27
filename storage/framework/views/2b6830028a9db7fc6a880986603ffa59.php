<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin Panel'); ?> - Bagx</title>
     <link rel="icon" type="image/png" href="<?php echo e(asset('storage/img/logo.png')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: #343a40;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 0.75rem 1rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: #495057;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar position-fixed" style="width: 250px;">
            <div class="p-3">
                  <a class="navbar-brand d-flex align-items-center" href="<?php echo e(route('home')); ?>">
            <img src="<?php echo e(asset('storage/img/logo.png')); ?>" alt="Bagx Logo" style="height: 40px; width: auto; margin-right: 10px;" onerror="this.src='/placeholder.svg?height=50&width=100';">
        </a>
                <hr class="text-white">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('admin.dashboard')); ?>">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('admin.products.index')); ?>">
                            <i class="fas fa-box me-2"></i> Sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('admin.categories.index')); ?>">
                            <i class="fas fa-tags me-2"></i> Danh mục
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.brands.*') ? 'active' : ''); ?>" 
                        href="<?php echo e(route('admin.brands.index')); ?>">
                            <i class="fas fa-users me-2"></i> Thương hiệu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('admin.orders.index')); ?>">
                            <i class="fas fa-shopping-cart me-2"></i> Đơn hàng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>" 
                        href="<?php echo e(route('admin.users.index')); ?>">
                            <i class="fas fa-users me-2"></i> Người dùng
                        </a>
                    </li>                   
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('home')); ?>" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i> Xem website
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="nav-link btn btn-link text-start w-100">
                                <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h2>
                <div>
                    <span class="text-muted">Xin chào, <?php echo e(auth()->user()->full_name); ?></span>
                </div>
            </div>

            <!-- Alerts -->
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Content -->
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JavaScript trong index.blade.php hoặc file riêng -->

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /home/bagxidvn/public_html/resources/views/admin/layouts/app.blade.php ENDPATH**/ ?>
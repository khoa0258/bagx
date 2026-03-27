<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ImageController as AdminImageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BrandController; // Đảm bảo import đúng namespace
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{slug}', [ProductController::class, 'category'])->name('products.category');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::post('/cart/buy-now', [CartController::class, 'buyNow'])->name('cart.buy-now');

// Checkout Routes
Route::get('/checkout_form', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('frontend.checkout.success');

// VNPay Routes
Route::post('/vnpay_payment', [CheckoutController::class, 'vnpay_payment'])->name('vnpay.payment');


// User Orders
Route::middleware('auth')->group(function () {
    Route::get('/orders', [UserOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [UserOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [UserOrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{order}/reorder', [UserOrderController::class, 'reorder'])->name('orders.reorder');
});

// Thanh toán VNPay
Route::post('/vnpay_payment', [CheckoutController::class, 'vnpay_payment']);
Route::get('/vnpay_return', [CheckoutController::class, 'vnpay_return'])->name('vnpay.return');
// Dashboard
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
});

//brands
Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::resource('products', AdminProductController::class);
    
    // Images
    Route::delete('images/{image}', [AdminImageController::class, 'destroy'])->name('images.destroy');
    
    // Categories
    Route::get('categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create-main', [AdminCategoryController::class, 'createMain'])->name('categories.create-main');
    Route::post('categories/store-main', [AdminCategoryController::class, 'storeMain'])->name('categories.store-main');
    Route::get('categories/main/{category}/edit', [AdminCategoryController::class, 'editMain'])->name('categories.edit-main');
    Route::patch('categories/main/{category}', [AdminCategoryController::class, 'updateMain'])->name('categories.update-main');
    Route::delete('categories/main/{category}', [AdminCategoryController::class, 'destroyMain'])->name('categories.destroy-main');
    
    // Sub Categories
    Route::get('categories/create-sub', [AdminCategoryController::class, 'createSub'])->name('categories.create-sub');
    Route::post('categories/store-sub', [AdminCategoryController::class, 'storeSub'])->name('categories.store-sub');
    Route::get('categories/{category}/edit', [AdminCategoryController::class, 'editSub'])->name('categories.edit');
    Route::patch('categories/{category}', [AdminCategoryController::class, 'updateSub'])->name('categories.update');
    Route::delete('categories/{category}', [AdminCategoryController::class, 'destroySub'])->name('categories.destroy');
    
    // Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::get('orders/{order}/edit', [AdminOrderController::class, 'edit'])->name('orders.edit');
    Route::patch('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
    Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::patch('orders/{order}/payment', [AdminOrderController::class, 'updatePayment'])->name('orders.update-payment');

    // Quản lý user
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('users/{user}', [UserController::class, 'update'])->name('users.update');

    // Brands
    Route::resource('brands', BrandController::class);
});




// Debug route
Route::get('/debug', function () {
    try {
        $dbConnection = DB::connection()->getPdo();
        $products = \App\Models\Product::count();
        $categories = \App\Models\MainCategory::count();
        
        return response()->json([
            'database_connected' => true,
            'products_count' => $products,
            'categories_count' => $categories,
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'database_connected' => false,
            'error' => $e->getMessage()
        ]);
    }
});

require __DIR__.'/auth.php';
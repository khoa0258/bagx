<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;

// Route test để kiểm tra API
Route::get('/test', function () {
    return response()->json(['message' => 'API hoạt động']);
});

// Route xử lý callback VNPAY
Route::get('/checkout', [CheckoutController::class, 'vnpay_return']);
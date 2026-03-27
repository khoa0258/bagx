<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        // Đảm bảo người dùng chưa đăng nhập
        if (Auth::check()) {
            return redirect()->route('home')->with('error', 'Bạn đã đăng nhập. Vui lòng đăng xuất để đăng ký tài khoản mới.');
        }
        return view('auth.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'roles' => 1, // Mặc định là user
            'gender' => 0, // Mặc định không xác định
            'account_lock' => 1, // Mặc định tài khoản hoạt động
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Đăng ký thành công!');
    }
}
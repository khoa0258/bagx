<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Bảo vệ route
    }

    // Hiển thị form chỉnh sửa profile
    public function edit()
    {
        $user = Auth::user();
        return view('frontend.profile.edit', compact('user'));
    }

    // Cập nhật thông tin cá nhân
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'last_name' => 'required|string|max:50',
            'first_name' => 'required|string|max:50',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'dob' => 'nullable|date',
            'phone' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'gender' => 'required|in:0,1,2', // 0 - false, 1 - male, 2 - female
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Giới hạn file avatar
        ]);

        // Xử lý upload avatar nếu có
        if ($request->hasFile('avatar')) {
            // Xóa avatar cũ nếu tồn tại
            if ($user->avatar) {
                Storage::delete('public/' . $user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Thông tin cá nhân đã được cập nhật thành công!');
    }

    // Xóa tài khoản
    public function destroy(Request $request)
    {
        $user = Auth::user();

        // Kiểm tra mật khẩu trước khi xóa (tăng bảo mật)
        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Mật khẩu không đúng!']);
        }

        // Xóa avatar nếu có
        if ($user->avatar) {
            Storage::delete('public/' . $user->avatar);
        }

        // Xóa tài khoản
        $user->delete();

        // Đăng xuất sau khi xóa
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Tài khoản đã được xóa thành công!');
    }

    // Đổi mật khẩu
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Kiểm tra mật khẩu cũ
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng!']);
        }

        // Cập nhật mật khẩu mới
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.edit')->with('success', 'Mật khẩu đã được thay đổi thành công!');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        try {
            $users = User::paginate(10);
            return view('admin.users.index', compact('users'));
        } catch (\Exception $e) {
            Log::error('Error in UserController@index: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', 'Không thể tải danh sách người dùng: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(RegisterRequest $request)
    {
        try {
            User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'password' => Hash::make($request->password),
                'roles' => $request->roles ?? 1,
                'account_lock' => $request->account_lock ?? 1,
                'gender' => $request->gender ?? 0,
            ]);

            return redirect()->route('admin.users.index')->with('success', 'User được tạo thành công!');
        } catch (\Exception $e) {
            Log::error('Error in UserController@store: ' . $e->getMessage());
            return redirect()->route('admin.users.create')->with('error', 'Không thể tạo user: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            if ($user->isAdmin() && User::countAdmins() === 1 && $user->id === Auth::id()) {
                return redirect()->route('admin.users.index')->with('error', 'Không thể xóa admin cuối cùng!');
            }

            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'User được xóa thành công!');
        } catch (\Exception $e) {
            Log::error('Error in UserController@destroy: ' . $e->getMessage());
            return redirect()->route('admin.users.index')->with('error', 'Không thể xóa user: ' . $e->getMessage());
        }
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(RegisterRequest $request, User $user)
    {
        try {
            $data = $request->only([
                'first_name',
                'last_name',
                'email',
                'phone',
                'address',
                'dob',
                'roles',
                'account_lock',
                'gender',
            ]);

            if ($request->hasFile('avatar')) {
                // Xóa avatar cũ nếu có
                if ($user->avatar && \Storage::disk('public')->exists($user->avatar)) {
                    \Storage::disk('public')->delete($user->avatar);
                }
                $path = $request->file('avatar')->store('avatars', 'public');
                $data['avatar'] = $path;
            }

            $user->update($data);

            return redirect()->route('admin.users.index')->with('success', 'User được cập nhật thành công!');
        } catch (\Exception $e) {
            Log::error('Error in UserController@update: ' . $e->getMessage());
            return redirect()->route('admin.users.edit', $user->id)->with('error', 'Không thể cập nhật user: ' . $e->getMessage());
        }
    }
}
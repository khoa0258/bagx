@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa User')
@section('page-title', 'Chỉnh sửa User')

@section('content')
<div class="container-fluid py-4">
    <h1 class="h3 mb-4">Chỉnh sửa User</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="first_name" class="form-label">Họ</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}" required>
                    @error('first_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="last_name" class="form-label">Tên</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}" required>
                    @error('last_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Địa chỉ</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $user->address) }}">
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="dob" class="form-label">Ngày sinh</label>
                    <input type="date" name="dob" id="dob" class="form-control" value="{{ old('dob', $user->dob) }}">
                    @error('dob')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="roles" class="form-label">Vai trò</label>
                    <select name="roles" id="roles" class="form-select" required>
                        <option value="1" {{ old('roles', $user->roles) == 1 ? 'selected' : '' }}>User</option>
                        <option value="2" {{ old('roles', $user->roles) == 2 ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('roles')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="account_lock" class="form-label">Trạng thái</label>
                    <select name="account_lock" id="account_lock" class="form-select" required>
                        <option value="1" {{ old('account_lock', $user->account_lock) == 1 ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ old('account_lock', $user->account_lock) == 0 ? 'selected' : '' }}>Khóa</option>
                    </select>
                    @error('account_lock')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="gender" class="form-label">Giới tính</label>
                    <select name="gender" id="gender" class="form-select">
                        <option value="0" {{ old('gender', $user->gender) == 0 ? 'selected' : '' }}>Nam</option>
                        <option value="1" {{ old('gender', $user->gender) == 1 ? 'selected' : '' }}>Nữ</option>
                        <option value="2" {{ old('gender', $user->gender) == 2 ? 'selected' : '' }}>Khác</option>
                    </select>
                    @error('gender')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="avatar" class="form-label">Ảnh đại diện</label>
                    <input type="file" name="avatar" id="avatar" class="form-control">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" width="100" class="mt-2">
                    @endif
                    @error('avatar')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">Hủy</a>
                    <button type="submit" class="btn btn-primary" enctype="multipart/form-data">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
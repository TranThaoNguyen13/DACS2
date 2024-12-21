@extends('layouts.admin')

@section('title', 'Thêm người dùng mới')

@section('content')
<div class="container">
    <h2>Thêm người dùng mới</h2>

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div>
            <label for="username">Tên</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div>
            <label for="password">Mật khẩu</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <label for="password_confirmation">Xác nhận mật khẩu</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>
        <div>
            <label for="role">Vai trò</label>
            <select name="role" id="role" required>
                <option value="0">Khách hàng</option>
                <option value="1">Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Thêm người dùng</button>
    </form>
</div>
@endsection

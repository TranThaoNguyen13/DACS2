@extends('layouts.admin')

@section('title', 'Quản lý người dùng')

<style>
    .table thead th {
    position: sticky;
    top: 0;
    background-color: #f8f9fa; /* Màu nền của tiêu đề */
    z-index: 1;
}

</style>
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Quản Lý Người Dùng</h1>
        <div class="d-flex">
            <!-- Nút thêm danh mục -->
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Thêm người dùng mới</a>
            
            <!-- Thanh tìm kiếm -->
            <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex ms-3">
                <input type="text" name="query" class="form-control me-2" placeholder="Tìm kiếm tài khoản..." value="{{ request('query') }}">
                <button type="submit" class="btn btn-primary">Tìm</button>
            </form>
        </div>
    </div>
    <div class="table-container mt-3" style="max-height: 500px; overflow-y: auto;">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Mật khẩu</th>
                <th>Vai trò</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->password}}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
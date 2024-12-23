@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Quản Lý Nhân Viên</h1>
        <div class="d-flex">
            <!-- Nút thêm danh mục -->
            <a href="{{ route('admin.nhanvien.create') }}" class="btn btn-primary">Thêm nhân viên mới</a>
            
            <!-- Thanh tìm kiếm -->
            <form action="{{ route('admin.nhanvien.index') }}" method="GET" class="d-flex ms-3">
                <input type="text" name="query" class="form-control me-2" placeholder="Tìm kiếm nhân viên..." value="{{ request('query') }}">
                <button type="submit" class="btn btn-primary">Tìm</button>
            </form>
        </div>
    </div>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ Tên</th>
                <th>Ngày Sinh</th>
                <th>Số Điện Thoại</th>
                <th>Email</th>
                <th>Địa Chỉ</th>
                <th>Chức Vụ</th>
                <th>Lương</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
        @foreach($nhanvien as $nv) <!-- Dùng tên biến đúng như trong controller -->
    <tr>
        <td>{{ $nv->id }}</td>
        <td>{{ $nv->name }}</td>
        <td>{{ $nv->birthday }}</td>
        <td>{{ $nv->phone }}</td>
        <td>{{ $nv->email }}</td>
        <td>{{ $nv->address }}</td>
        <td>{{ $nv->function }}</td>
        <td>{{ $nv->wage }}</td>
        <td>
            <a href="{{ route('admin.nhanvien.edit', $nv->id) }}" class="btn btn-warning btn-sm">Sửa</a>
            <form action="{{ route('admin.nhanvien.destroy', $nv->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
            </form>
        </td>
    </tr>
@endforeach

        </tbody>
    </table>
</div>
@endsection
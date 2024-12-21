@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Danh Sách Nhân Viên</h2>
    <a href="{{ route('admin.nhanvien.create') }}" class="btn btn-primary mb-3">Thêm Nhân Viên</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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

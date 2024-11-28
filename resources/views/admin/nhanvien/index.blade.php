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
            @foreach($nhanviens as $nhanvien)
            <tr>
                <td>{{ $nhanvien->id }}</td>
                <td>{{ $nhanvien->name }}</td>
                <td>{{ $nhanvien->birthday }}</td>
                <td>{{ $nhanvien->phone }}</td>
                <td>{{ $nhanvien->email }}</td>
                <td>{{ $nhanvien->address }}</td>
                <td>{{ $nhanvien->function }}</td>
                <td>{{ $nhanvien->wage }}</td>
                <td>
                    <a href="{{ route('admin.nhanvien.edit', $nhanvien->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('admin.nhanvien.destroy', $nhanvien->id) }}" method="POST" style="display:inline-block;">
    @csrf
    @method('DELETE') <!-- Đây là cách để Laravel nhận diện phương thức DELETE -->
    <button class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
</form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

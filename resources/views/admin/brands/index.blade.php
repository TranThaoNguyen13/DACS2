@extends('layouts.admin')
<style>
    /* Đặt tiêu đề bảng cố định ở trên cùng */
    .table thead th {
        position: sticky;
        top: 0;
        background-color: #f8f9fa; /* Màu nền của tiêu đề */
        z-index: 1;
    }

    /* Tạo vùng cuộn cho bảng */
    .table-wrapper {
        max-height: 500px; /* Đặt chiều cao tối đa cho vùng cuộn */
        overflow-y: auto; /* Hiển thị thanh cuộn dọc khi có nhiều hơn 10 sản phẩm */
        display: block;
    }

    .table {
        width: 100%;
        table-layout: fixed;
    }

    /* Đặt chiều rộng cho các cột */
    .table th:nth-child(7), .table td:nth-child(7) { /* Cột 'Thương hiệu' */
        width: 10%; /* Chiều rộng nhỏ cho cột 'Thương hiệu' */
    }

    .table th:nth-child(8), .table td:nth-child(8) { /* Cột 'Danh mục' */
        width: 10%; /* Chiều rộng nhỏ cho cột 'Danh mục' */
    }
</style>
@section('title', 'Quản lý thương hiệu')

@section('content') 

    <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Quản Lý Thương Hiệu</h1>
        <div class="d-flex">
            <!-- Nút thêm sản phẩm -->
            <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">Thêm thương hiệu mới</a>
            
            <!-- Thanh tìm kiếm -->
            <form action="{{ route('admin.brands.index') }}" method="GET" class="d-flex">
                <input type="text" name="query" class="form-control me-2" placeholder="Tìm kiếm thương hiệu..." value="{{ request('query') }}">
                <button type="submit" class="btn btn-primary">Tìm</button>
            </form>
        </div>
    </div>

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên thương hiệu</th>
                <th>Hình ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($brands as $brand)
                <tr>
                    <td>{{ $brand->id }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>{{ $brand->image }}</td>
                    <td>
                        <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa thương hiệu này?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
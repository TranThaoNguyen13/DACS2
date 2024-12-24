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
    .table th:nth-child(1), .table td:nth-child(1) { /* Cột 'Thương hiệu' */
        width: 6%; /* Chiều rộng nhỏ cho cột 'Thương hiệu' */
    }

    .table th:nth-child(2), .table td:nth-child(2) { /* Cột 'Danh mục' */
        width: 10%; /* Chiều rộng nhỏ cho cột 'Danh mục' */
    }
    .table th:nth-child(3), .table td:nth-child(3) { /* Cột 'Thương hiệu' */
        width: 10%; /* Chiều rộng nhỏ cho cột 'Thương hiệu' */
    }

    .table th:nth-child(4), .table td:nth-child(4) { /* Cột 'Danh mục' */
        width: 10%; /* Chiều rộng nhỏ cho cột 'Danh mục' */
    }
    .table th:nth-child(6), .table td:nth-child(6) { /* Cột 'Thương hiệu' */
        width: 12%; /* Chiều rộng nhỏ cho cột 'Thương hiệu' */
    }

</style>

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Quản Lý Hệ thống cửa hàng</h1>
        <div class="d-flex">
            <!-- Nút thêm sản phẩm -->
            <a href="{{ route('admin.stores.create') }}" class="btn btn-success me-2">Thêm Vị trí cửa hàng mới</a>
            
            <!-- Thanh tìm kiếm -->
            <form action="{{ route('admin.stores.index') }}" method="GET" class="d-flex">
                <input type="text" name="query" class="form-control me-2" placeholder="Tìm kiếm vị trí cửa hàng..." value="{{ request()->query('query') }}">
                <button type="submit" class="btn btn-primary">Tìm</button>
            </form>
        </div>
    </div>

    <!-- Bọc bảng trong div có class 'table-wrapper' để tạo vùng cuộn -->
    <div class="table-wrapper">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên cửa hàng</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Link bản đồ</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @if($stores->isEmpty())
                    <tr>
                        <td colspan="10" class="text-center">Không tìm thấy cửa hàng nào.</td>
                    </tr>
                @else
                    @foreach($stores as $store)
                        <tr>
                            <td>{{ $store->id }}</td>
                            <td>{{ $store->name }}</td>
                            <td>{{ $store->address }}</td>
                            <td>{{ $store->phone }}</td>
                            <td>{{ $store->map_url}}</td>
                            <td>
                                <a href="{{ route('admin.stores.edit', $store->id) }}" class="btn btn-warning">Sửa</a>
                                <form action="{{ route('admin.stores.destroy', $store->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
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

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Quản Lý Sản Phẩm</h1>
        <div class="d-flex">
            <!-- Nút thêm sản phẩm -->
            <a href="{{ route('admin.products.create') }}" class="btn btn-success me-2">Thêm Sản Phẩm Mới</a>
            
            <!-- Thanh tìm kiếm -->
            <form action="{{ route('admin.products.index') }}" method="GET" class="d-flex">
                <input type="text" name="query" class="form-control me-2" placeholder="Tìm kiếm sản phẩm..." value="{{ request()->query('query') }}">
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
                    <th>Tên Sản Phẩm</th>
                    <th>Giá mới</th>
                    <th>Giá cũ</th>
                    <th>Ảnh</th>
                    <th>Mô tả</th>
                    <th>Thương hiệu</th>
                    <th>Danh mục</th>
                    <th>Số lượng đã bán</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @if($products->isEmpty())
                    <tr>
                        <td colspan="10" class="text-center">Không tìm thấy sản phẩm nào.</td>
                    </tr>
                @else
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ number_format($product->new_price, 0, ',', '.') }}.000đ</td>
                            <td>{{ number_format($product->old_price, 0, ',', '.') }}.000đ</td>
<td> 
                                <img src="{{ asset('images/' . $product->image) }}" style="width: 100px;" alt="{{ $product->name }}">
                            </td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->brand->name ?? 'Không có thương hiệu' }}</td>
                            <td>{{ $product->category->name ?? 'Không có danh mục' }}</td>
                            <td>{{ $product->sold }}</td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">Sửa</a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
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
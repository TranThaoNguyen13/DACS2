<!-- resources/views/admin/products/index.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container">
    <div><h1>Quản Lý Sản Phẩm</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-success mb-3">Thêm Sản Phẩm Mới</a></div>
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
                <th>Ngày cập nhật</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
        @if($products->isEmpty())
            <p>Không có sản phẩm nào để hiển thị.</p>
            @else
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->new_price }}.000đ</td>
                <td>{{ $product->old_price }}.000đ</td>
                <td>{{ $product->image }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->brand_id}}</td>
                <td>{{ $product->category_id }}</td>
                <td>{{ $product->sold }}</td>
                <td>{{ $product->updated_at }}</td>
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
@endsection

@extends('layouts.admin')

@section('title', 'Quản lý danh mục')

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
    <h1>Quản lý danh mục</h1>
    <div class="d-flex">
            <!-- Nút thêm sản phẩm -->
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Thêm danh mục mới</a>
            
            <!-- Thanh tìm kiếm -->
            <form action="{{ route('admin.categories.index') }}" method="GET" class="d-flex">
                <input type="text" name="query" class="form-control me-2" placeholder="Tìm kiếm thương hiệu..." value="{{ request('query') }}">
                <button type="submit" class="btn btn-primary">Tìm</button>
            </form>
        </div>
</div>
    <div class="table-container mt-3" style="max-height: 500px; overflow-y: auto;">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Hình ảnh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            @if($category->image)
                            <img src="{{ asset('images/' . $category->image) }}" alt="{{ $category->name }} " style="width: 100px;">
                            @else
                                Chưa có hình ảnh
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection

@extends('layouts.admin')

@section('content')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <h1>Thêm sản phẩm mới</h1>
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="name">Tên sản phẩm:</label>
            <input type="text" id="name" name="name" required>
        </div>
        
        <div>
            <label for="category_id">Danh mục:</label>
            <select id="category_id" name="category_id">
                <!-- Ví dụ để hiển thị danh sách danh mục -->
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="new_price">Giá mới:</label>
            <input type="number" id="new_price" name="new_price" required>
        </div>

        <div>
            <label for="old_price">Giá cũ:</label>
            <input type="number" id="old_price" name="old_price">
        </div>

        <div>
            <label for="image">Hình ảnh:</label>
            <input type="file" id="image" name="image">
        </div>

        <div>
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description"></textarea>
            <script>
            CKEDITOR.replace('description');
            </script>
        </div>

        <div>
            <label for="brand_id">Thương hiệu:</label>
            <select id="brand_id" name="brand_id">
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit">Thêm sản phẩm</button>
    </form>
    @endsection

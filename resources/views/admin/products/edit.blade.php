@extends('layouts.admin')

@section('content')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<div class="container">
    <h1>Chỉnh Sửa Sản Phẩm</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Tên Sản Phẩm</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="form-group">
            <label for="new_price">Giá Mới</label>
            <input type="number" name="new_price" class="form-control" value="{{ old('new_price', $product->new_price) }}" required>
        </div>

        <div class="form-group">
            <label for="old_price">Giá Cũ</label>
            <input type="number" name="old_price" class="form-control" value="{{ old('old_price', $product->old_price) }}">
        </div>

        <div class="form-group">
        
            <label for="description">Mô Tả</label>
            <textarea name="description" id="description" class="form-control" rows="10">{{!! old('description', $product->description) !!}}</textarea>
        </div>

        <div class="form-group">
            <label for="brand_id">Thương Hiệu</label>
            <input type="number" name="brand_id" class="form-control" value="{{ old('brand_id', $product->brand_id) }}" required>
        </div>

        <div class="form-group">
            <label for="category_id">Danh Mục</label>
            <input type="number" name="category_id" class="form-control" value="{{ old('category_id', $product->category_id) }}" required>
        </div>

        <div class="form-group">
            <label for="sold">Số Lượng Đã Bán</label>
            <input type="number" name="sold" class="form-control" value="{{ old('sold', $product->sold) }}">
        </div>

        <div class="form-group">
            <label for="image">Ảnh</label>
            <input type="file" name="image" class="form-control">
            @if ($product->image)
                <p>Ảnh hiện tại: <img src="{{ asset('storage/' . $product->image) }}" alt="Ảnh sản phẩm" width="100"></p>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Cập Nhật Sản Phẩm</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<script>
    ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => {
            console.error(error);
        });
</script>

@endsection

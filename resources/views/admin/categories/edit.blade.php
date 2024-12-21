<!-- resources/views/admin/edit_category.blade.php -->
@extends('layouts.admin')
<h2>Chỉnh sửa danh mục</h2>

@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="name">Tên danh mục:</label>
    <input type="text" id="name" name="name" value="{{ $category->name }}" required>
    
    <div>
        <label for="image">Hình ảnh mới:</label>
        <input type="file" name="image" id="image">
    </div>


    <button type="submit">Cập nhật</button>
</form>
@endsection

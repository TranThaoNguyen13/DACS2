<!-- resources/views/admin/create_category.blade.php -->
@extends('layouts.admin')

@section('content')
<h2>Thêm danh mục mới</h2>

@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="name">Tên danh mục</label>
        <input type="text" name="name" id="name" required>
    </div>
    <div>
        <label for="image" >Hình ảnh</label>
        <input type="file" name="image" id="image"></input>
    </div>
    <button type="submit">Thêm danh mục</button>
</form>


@endsection
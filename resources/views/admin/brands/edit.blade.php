@extends('layouts.admin')

@section('title', 'Chỉnh sửa thương hiệu')

@section('content')
<div class="container">
    <h2>Chỉnh sửa thương hiệu</h2>

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Tên thương hiệu</label>
            <input type="text" name="name" id="name" value="{{ $brand->name }}" required>
        </div>
        <div>
            <label for="description">Mô tả</label>
            <textarea name="description" id="description">{{ $brand->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật thương hiệu</button>
    </form>
</div>
@endsection

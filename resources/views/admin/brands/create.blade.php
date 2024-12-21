@extends('layouts.admin')

@section('title', 'Thêm thương hiệu mới')

@section('content')
<div class="container">
    <h2>Thêm thương hiệu mới</h2>

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="name">Tên thương hiệu</label>
        <input type="text" name="name" id="name" required>
    </div>
    <div>
        <label for="image">Hình ảnh:</label>
        <input type="file" id="image" name="image">
    </div>
    <button type="submit" class="btn btn-success">Thêm thương hiệu</button>
</form>

</div>
@endsection

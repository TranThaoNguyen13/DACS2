@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Thêm Cửa Hàng Mới</h1>

    <form action="{{ route('admin.stores.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên Cửa Hàng</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Địa Chỉ</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Số Điện Thoại</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="mb-3">
            <label for="map_url" class="form-label">Link Bản Đồ</label>
            <input type="url" class="form-control" id="map_url" name="map_url">
        </div>
        <button type="submit" class="btn btn-primary">Thêm Cửa Hàng</button>
    </form>
</div>
@endsection

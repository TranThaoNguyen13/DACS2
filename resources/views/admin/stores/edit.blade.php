@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Chỉnh Sửa Cửa Hàng</h1>

    <form action="{{ route('admin.stores.update', $store->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Tên Cửa Hàng</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $store->name }}" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Địa Chỉ</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ $store->address }}" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Số Điện Thoại</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $store->phone }}" required>
        </div>
        <div class="mb-3">
            <label for="map_url" class="form-label">Link Bản Đồ</label>
            <input type="url" class="form-control" id="map_url" name="map_url" value="{{ $store->map_url }}">
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật Cửa Hàng</button>
    </form>
</div>
@endsection

@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Sửa Nhân Viên</h2>
    <form action="{{ route('admin.nhanvien.update', $nhanvien->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="ho_ten">Họ Tên:</label>
            <input type="text" name="ho_ten" class="form-control" value="{{ $nhanvien->ho_ten }}" required>
        </div>
        <div class="mb-3">
            <label for="ngay_sinh">Ngày Sinh:</label>
            <input type="date" name="ngay_sinh" class="form-control" value="{{ $nhanvien->ngay_sinh }}" required>
        </div>
        <div class="mb-3">
            <label for="so_dien_thoai">Số Điện Thoại:</label>
            <input type="text" name="so_dien_thoai" class="form-control" value="{{ $nhanvien->so_dien_thoai }}" required>
        </div>
        <div class="mb-3">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ $nhanvien->email }}" required>
        </div>
        <div class="mb-3">
            <label for="dia_chi">Địa Chỉ:</label>
            <textarea name="dia_chi" class="form-control" required>{{ $nhanvien->dia_chi }}</textarea>
        </div>
        <div class="mb-3">
            <label for="chuc_vu">Chức Vụ:</label>
            <input type="text" name="chuc_vu" class="form-control" value="{{ $nhanvien->chuc_vu }}" required>
        </div>
        
        <div class="mb-3">
            <label for="luong">Lương:</label>
            <input type="number" name="luong" class="form-control" value="{{ $nhanvien->luong }}" required>
        </div>
        <button type="submit" class="btn btn-success">Cập Nhật</button>
    </form>
</div>
@endsection

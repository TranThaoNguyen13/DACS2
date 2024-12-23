@extends('layouts.admin')

@section('content')
@section('content')
<div class="container">
    @if ($errors->any())  <!-- Kiểm tra nếu có lỗi -->
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)  <!-- Lặp qua các lỗi -->
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    
<div class="container">
    <h2>Thêm Nhân Viên</h2>
    <!-- Kiểm tra và hiển thị thông báo thành công -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.nhanvien.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name">Họ Tên:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="birthday">Ngày Sinh:</label>
            <input type="date" name="birthday" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="phone">Số Điện Thoại:</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="dia_chi">Địa Chỉ:</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="function">Chức Vụ:</label>
            <input type="text" name="function" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="wage">Lương:</label>
            <input type="number" name="wage" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Thêm Nhân Viên</button>
    </form>
</div>

@if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection
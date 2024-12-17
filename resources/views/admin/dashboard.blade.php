<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Chào mừng đến với Bảng Điều Khiển Admin</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Quản Lý Sản Phẩm</h5>
                    <p class="card-text">Thêm, chỉnh sửa và xóa sản phẩm.</p>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Quản Lý Sản Phẩm</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Quản Lý Đơn Hàng</h5>
                    <p class="card-text">Theo dõi và cập nhật trạng thái đơn hàng.</p>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Quản Lý Đơn Hàng</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Quản Lý Danh Mục</h5>
                    <p class="card-text">Thêm, chỉnh sửa và xóa danh mục sản phẩm.</p>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Quản Lý Danh Mục</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Quản Lý Thương Hiệu</h5>
                    <p class="card-text">Thêm, chỉnh sửa và xóa thương hiệu sản phẩm.</p>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-primary">Quản Lý Thương Hiệu</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Quản Lý Người Dùng</h5>
                    <p class="card-text">Quản lý thông tin người dùng và phân quyền.</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Quản Lý Người Dùng</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Quản Lý Nhân Viên</h5>
                    <p class="card-text">Quản lý thông tin nhân viên.</p>
                    <a href="{{ route('admin.nhanvien.index') }}" class="btn btn-primary">Quản Lý Nhân Viên</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="card text-center">
                 <div class="card-body">
                     <h5 class="card-title">Quản Lý Bình Luận</h5>
                    <p class="card-text">Duyệt và trả lời các bình luận của người dùng.</p>
                    <a href="{{ route('admin.comments.index') }}" class="btn btn-primary">Quản Lý Bình Luận</a>
                 </div>
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Xem Báo Cáo Doanh Thu</h5>
                    <p class="card-text">Xem tổng doanh thu của cửa hàng.</p>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-primary">Xem Báo Cáo</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

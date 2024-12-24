@extends('layouts.app')
@php
    $status = $status ?? 'all';
@endphp

@section('title', 'Lịch Sử Mua Hàng')

@section('content')
<style>
    .table-wrapper {
    max-height: 400px; /* Chiều cao tối đa cho phần nội dung bảng */
    overflow-y: auto; /* Kích hoạt cuộn dọc */
    border: 1px solid #ddd; /* Thêm đường viền cho bảng */
}

.table thead th {
    position: sticky;
    top: 0; /* Cố định tiêu đề ở trên cùng */
    background-color: #f8f9fa; /* Màu nền cho tiêu đề */
    z-index: 1; /* Đảm bảo tiêu đề luôn nằm trên các dòng dữ liệu */
}

</style>
<div class="container">
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Lịch Sử Mua Hàng</h2>
 
    <!-- Thanh menu -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ empty($status) ? 'active' : '' }}" href="{{ route('order.history') }}">Tất cả</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status == 'Chờ xác nhận' ? 'active' : '' }}" href="{{ route('order.history', ['status' => 'Chờ xác nhận']) }}">Chờ xác nhận</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status == 'Đã xác nhận' ? 'active' : '' }}" href="{{ route('order.history', ['status' => 'Đã xác nhận']) }}">Đã xác nhận</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status == 'Đang vận chuyển' ? 'active' : '' }}" href="{{ route('order.history', ['status' => 'Đang vận chuyển']) }}">Đang vận chuyển</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status == 'Đã vận chuyển' ? 'active' : '' }}" href="{{ route('order.history', ['status' => 'Đã vận chuyển']) }}">Đã vận chuyển</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status == 'Đã nhận' ? 'active' : '' }}" href="{{ route('order.history', ['status' => 'Đã nhận']) }}">Đã nhận</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status == 'Trả đơn/Hoàn hàng' ? 'active' : '' }}" href="{{ route('order.history', ['status' => 'Trả đơn/Hoàn hàng']) }}">Trả đơn/Hoàn hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status == 'Đã huỷ' ? 'active' : '' }}" href="{{ route('order.history', ['status' => 'Đã huỷ']) }}">Đã huỷ</a>
        </li>
    </ul>

    <!-- Bảng lịch sử đơn hàng -->
    <div class="table-wrapper mt-3">
        <table class="table">
            <thead>
                <tr>
                    <th>Mã Đơn Hàng</th>
                    <th>Ngày Mua</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng Thái</th>
                    <th>Họ và tên</th>
                    <th>Địa chỉ</th>
                    <th>Phương thức thanh toán</th>
                    <th>SĐT</th>
                    <th>Email</th>
                    <th>ID sản phẩm</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ number_format($order->total, 0, ',', '.') }}.000đ</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->username }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ $order->payment_method }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->email }}</td>
                        <td>{{ $order->product_id }}</td>
                        <td>
    <a href="{{ route('order.details', $order->id) }}" class="btn btn-info">Xem Chi Tiết</a>
    @if($order->status == 'Chờ xác nhận')
        <form action="{{ route('order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
            @csrf
            <button type="submit" class="btn btn-danger">Hủy Đơn Hàng</button>
        </form>
    @elseif($order->status == 'Đã nhận')
        <form action="{{ route('order.return', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn trả đơn hàng này?');">
            @csrf
            <button type="submit" class="btn btn-warning">Trả Đơn/Hàng Hoàn</button>
        </form>
    @else
        <button class="btn btn-secondary" disabled>Không thể hủy</button>
    @endif
</td>

                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Không có đơn hàng nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Nút quay lại -->
    <button onclick="window.location='{{ route('customer.home') }}'" class="btn btn-primary mt-3">Quay lại Trang Chủ</button>
</div>
@endsection
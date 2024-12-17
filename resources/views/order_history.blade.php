@extends('layouts.app')
@php
    $status = $status ?? 'all';
@endphp

@section('title', 'Lịch Sử Mua Hàng')

@section('content')
<div class="container">
    <h2>Lịch Sử Mua Hàng</h2>

    <!-- Thanh menu -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ $status === 'all' ? 'active' : '' }}" href="{{ route('order.history', ['status' => 'all']) }}">Tất Cả</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status === 'confirmed' ? 'active' : '' }}" href="{{ route('order.history', ['status' => 'confirmed']) }}">Đã Xác Nhận</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status === 'shipping' ? 'active' : '' }}" href="{{ route('order.history', ['status' => 'shipping']) }}">Đang Vận Chuyển</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status === 'shipped' ? 'active' : '' }}" href="{{ route('order.history', ['status' => 'shipped']) }}">Đã Vận Chuyển</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status === 'received' ? 'active' : '' }}" href="{{ route('order.history', ['status' => 'received']) }}">Đã Nhận</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status === 'returned' ? 'active' : '' }}" href="{{ route('order.history', ['status' => 'returned']) }}">Trả Hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status === 'canceled' ? 'active' : '' }}" href="{{ route('order.history', ['status' => 'canceled']) }}">Đã Hủy</a>
        </li>
    </ul>

    <!-- Danh sách đơn hàng -->
    <table class="table mt-3">
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
                    <td>
                        @if($order->status == 'Pending')
                        <form action="{{ route('order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                            @csrf
                            <button type="submit" class="btn btn-danger">Hủy Đơn Hàng</button>
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
@endsection

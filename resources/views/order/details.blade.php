@extends('layouts.app')

@section('title', 'Chi Tiết Đơn Hàng')

@section('content')
<div class="container">
    <h2>Chi Tiết Đơn Hàng</h2>
    <p><strong>Mã Đơn Hàng:</strong> {{ $order->id }}</p>
    <p><strong>Ngày Mua:</strong> {{ $order->created_at }}</p>
    <p><strong>Tổng Tiền:</strong> {{ number_format($order->total, 0, ',', '.') }}.000đ</p>
    <p><strong>Trạng Thái:</strong> {{ $order->status }}</p>

    <h3>Sản Phẩm</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID Sản Phẩm</th>
                <th>Tên Sản Phẩm</th>
                <th>Hình ảnh</th>
                <th>Số Lượng</th>
                <th>Giá cũ</th>
                <th>Giá mới</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td> 
                                <img src="{{ asset('images/' . $product->image) }}" style="width: 100px;" alt="{{ $product->name }}">
                            </td>
                    <td>{{ $product->pivot->quantity }}</td> <!-- Sử dụng pivot để lấy số lượng -->
                    <td>{{ number_format($product->old_price, 0, ',', '.') }}.000đ</td>
                    <td>{{ number_format($product->new_price, 0, ',', '.') }}.000đ</td>
                    <td>{{ number_format($product->pivot->quantity * $product->new_price, 0, ',', '.') }}.000đ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Nút quay lại -->
    <button onclick="window.location='{{ route('order.history') }}'" class="btn btn-primary mt-3">Quay lại Lịch Sử Mua Hàng</button>
</div>
@endsection

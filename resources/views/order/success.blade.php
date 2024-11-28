@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Đặt hàng thành công!</h2>
    <p>Đơn hàng của bạn đã được xác nhận.</p>
    <p><strong>Mã đơn hàng: {{ $order->id }}</strong></p> <!-- Thêm dấu đóng strong -->
    <p>Tổng giá trị: {{ number_format($order->total, 0, ',', '.') }} VND</p> <!-- Chỉnh lại định dạng hiển thị -->
    <a href="{{ route('customer.home') }}" class="btn btn-primary">Trở về trang chủ</a>
</div>
@endsection

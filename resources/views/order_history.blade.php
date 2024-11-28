@extends('layouts.app')

@section('title', 'Lịch Sử Mua Hàng')

@section('content')
<div class="container">
    <h2>Lịch Sử Mua Hàng</h2>
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
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
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
            @endforeach
        </tbody>
    </table>
</div>
@endsection

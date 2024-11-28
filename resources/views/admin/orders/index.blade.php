@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Quản Lý Đơn Hàng</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Khách Hàng</th>
                <th>Giá</th>
                <th>Trạng thái</th>
                <th>Tên khách hàng</th>
                <th>Địa chỉ</th>
                <th>Phương thức thanh toán</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>ID Sản Phẩm</th>
                <th>Số lượng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user_id }}</td>
                    <td>{{ $order->total }}.000đ</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->username }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ $order->payment_method }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->product_id }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>
                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning">Chỉnh Sửa</a>
                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

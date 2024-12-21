@extends('layouts.admin')

@section('content')
    <h1>Chỉnh sửa đơn hàng</h1>
    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="status">Trạng thái</label>
            <select name="status" id="status" class="form-control" required>
                <option value="Chờ xác nhận" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                <option value="Đã xác nhận" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                <option value="Đang vận chuyển" {{ $order->status == 'shipping' ? 'selected' : '' }}>Đang vận chuyển</option>
                <option value="Đã vận chuyển" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đã vận chuyển</option>
                <option value="Đã nhận" {{ $order->status == 'received' ? 'selected' : '' }}>Đã nhận</option>
                <option value="Trả đơn/Hoàn hàng" {{ $order->status == 'returned' ? 'selected' : '' }}>Trả đơn/Hoàn hàng</option>
                <option value="Đã huỷ" {{ $order->status == 'canceled' ? 'selected' : '' }}>Đã huỷ</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
@endsection

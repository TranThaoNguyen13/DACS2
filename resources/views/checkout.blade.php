@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Thanh Toán</h2>

    <h4>Sản phẩm trong giỏ hàng</h4>
    <form action="{{ route('cart.update') }}" method="POST">
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá mới</th>
                    <th>Số lượng</th>
                    <th>Tổng giá</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $key => $item)
                    <tr>
                        <td><img src="{{ asset('images/' . $item['image']) }}" class="img-thumbnail" style="width: 80px;" alt="{{ $item['name'] }}"></td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ number_format($item['new_price'], 0, ',', '.') }}.000đ</td>
                        <td>
                            <input type="number" name="quantities[{{ $key }}]" value="{{ $item['quantity'] }}" min="1" class="form-control" style="width: 80px;">
                        </td>
                        <td>{{ number_format($item['new_price'] * $item['quantity'], 0, ',', '.') }}.000đ</td>
                        <td>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>

    <h4>Thông tin thanh toán</h4>
    <form action="{{ route('order.store') }}" method="POST">
    @csrf
    <!-- Lưu toàn bộ giỏ hàng vào input ẩn -->
    <input type="hidden" name="selected_products" value="{{ json_encode($cartItems) }}">
    <input type="hidden" name="total" value="{{ $total }}">
    
    <!-- Các trường thông tin thanh toán -->
    <div class="form-group">
        <label for="username">Tên người dùng</label>
        <input type="text" class="form-control" name="username" id="username" value="{{ auth()->user()->name }}" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" id="email" value="{{ auth()->user()->email }}" required>
    </div>
    <div class="form-group">
        <label for="phone">Số điện thoại</label>
        <input type="text" class="form-control" name="phone" id="phone" required>
    </div>
    <div class="form-group">
        <label for="address">Địa chỉ</label>
        <input type="text" class="form-control" name="address" id="address" required>
    </div>
    <div class="form-group">
        <label for="payment_method">Phương thức thanh toán</label>
        <select class="form-control" name="payment_method" id="payment_method" required>
            <option value="card">Thanh toán qua MoMo</option>
            <option value="cod">Thanh toán khi nhận hàng</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Xác nhận thanh toán</button>
</form>

</div>
@endsection

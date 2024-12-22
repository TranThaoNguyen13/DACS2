@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Giỏ Hàng</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(empty($cart) || count($cart) == 0)
        <div class="alert alert-warning">
            Giỏ hàng của bạn hiện tại không có sản phẩm.
        </div>
    @else
        <form action="{{ route('cart.checkoutSelected') }}" method="POST">
            @csrf
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá mới</th>
                        <th>Giá cũ</th>
                        <th>Số lượng</th>
                        <th>Tổng giá</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $id => $item)
                        <tr>
                            <td>
                                <input type="checkbox" name="selected_products[]" value="{{ $id }}">
                            </td>
                            <td>
                                <img src="{{ asset('images/' . (isset($item['image']) ? $item['image'] : 'default_image.jpg')) }}" class="img-thumbnail" style="width: 80px;" alt="{{ $item['name'] }}">
                            </td>
                            <td>{{ $item['name'] }}</td>
                            <td>
                                {{ isset($item['new_price']) ? number_format($item['new_price'], 0, ',', '.') . '.000đ' : 'Liên hệ' }}
                            </td>
                            <td>
                                {{ isset($item['old_price']) ? number_format($item['old_price'], 0, ',', '.') . '.000đ' : 'Liên hệ' }}
                            </td>
                            <td>
                                <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="number" name="quantities[{{ $id }}]" value="{{ $item['quantity'] }}" min="1" class="form-control quantity-input" style="width: 100px;">
                                    <button type="submit" class="btn btn-primary mt-2">Cập nhật</button>
                                </form>
                            </td>
                            <td>
                                {{ isset($item['new_price']) ? number_format($item['new_price'] * $item['quantity'], 0, ',', '.') . '.000đ' : 'Liên hệ' }}
                            </td>
                            <td>
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between">
                <div>
                    <p><strong>Tổng số sản phẩm:</strong> {{ $totalQuantity }}</p>
                    <p><strong>Tổng tiền:</strong> <span class="text-danger">{{ number_format($totalPrice, 0, ',', '.') }}.000đ</span></p>
                </div>
                <button type="submit" class="btn btn-success" {{ count($cart) == 0 ? 'disabled' : '' }}>Thanh toán sản phẩm đã chọn</button>
            </div>
        </form>

        <form action="{{ route('cart.checkoutAll') }}" method="POST" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-success" {{ count($cart) == 0 ? 'disabled' : '' }}>Thanh toán tất cả</button>
        </form>
    @endif
</div>
@endsection

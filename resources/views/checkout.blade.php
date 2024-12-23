@extends('layouts.app')
<script src="https://cdn.jsdelivr.net/npm/qrcode@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/qrcode-generator/qrcode.min.js"></script>
@section('content')
<div class="container mt-5">
    <h2>Giỏ Hàng</h2>

    <!-- Hiển thị sản phẩm trong giỏ hàng -->
    <h4>Sản phẩm trong giỏ hàng</h4>
    <form action="{{ route('cart.updatee') }}" method="POST">
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá mới</th>
                    <th>Số lượng</th>
                    <th>Tổng giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $key => $item)
                    <tr>
                        <td>
                            <img src="{{ asset('images/' . $item['image']) }}" class="img-thumbnail" style="width: 80px;" alt="{{ $item['name'] }}">
                        </td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ number_format($item['new_price'], 0, ',', '.') }}.000đ</td>
                        <td>
                            <input type="number" name="quantities[{{ $key }}]" value="{{ $item['quantity'] }}" min="1" class="form-control" style="width: 80px;">
                        </td>
                        <td>{{ number_format($item['new_price'] * $item['quantity'], 0, ',', '.') }}.000đ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Cập nhật giỏ hàng</button>
    </form>

    <!-- Nếu giỏ hàng có sản phẩm, hiển thị form thanh toán -->
    @if(count($cart) > 0)
        <h4 class="mt-5">Thông tin thanh toán</h4>
        <form action="{{ route('order.store') }}" method="POST">
            @csrf
            <!-- Giỏ hàng và tổng giá ẩn -->
            <input type="hidden" name="selected_products" value="{{ json_encode($cart) }}">
            <input type="hidden" name="total" value="{{ $total }}">

            <!-- Các trường thông tin thanh toán -->
            <div class="form-group">
                <label for="username">Tên người dùng</label>
                <input type="text" class="form-control" name="username" id="username" value="{{ optional(auth()->user())->name }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ optional(auth()->user())->email }}" required>
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="text" class="form-control" name="phone" id="phone" required>
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <input type="text" class="form-control" name="address" id="address" required>
            </div>
            <div class="mb-3">
                    <label for="payment_method">Phương thức thanh toán</label>
                    <select class="form-control" name="payment_method" id="payment_method" required>
                        <option value="cod">Thanh toán khi nhận hàng</option>
                        <option value="card">Thanh toán qua MoMo</option>
                    </select>
                </div><br>

                <!-- Khu vực hiển thị mã QR MoMo -->
                <div id="momoQRCode" class="mt-3" style="display: none;">
    <h4>Mã QR thanh toán MoMo:</h4>
    <div id="qrCodeContainer"></div>
</div>

            <button type="submit" class="btn btn-success mt-3">Xác nhận thanh toán</button>
        </form>
    @else
        <p>Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm vào giỏ hàng.</p>
    @endif
</div>

<script>
    $(document).ready(function () {
        // Khi chọn phương thức thanh toán MoMo
        $('#payment_method').on('change', function () {
            const paymentMethod = $(this).val();
            if (paymentMethod === 'card') {
                $('#momoQRCode').show();
                generateQRCode();
            } else {
                $('#momoQRCode').hide();
            }
        });

        function generateQRCode() {
    const username = $("input[name='username']").val();
    const address = $("input[name='address']").val();
    const phone = $("input[name='phone']").val();
    const email = $("input[name='email']").val();
    const total = {{ $total }}; // Tổng tiền từ controller

    if (!username || !address || !phone || !email) {
        alert('Vui lòng nhập đầy đủ thông tin!');
        return;
    }

    const paymentData = `Tên: ${username}\n` +
        `Địa chỉ: ${address}\n` +
        `SĐT: ${phone}\n` +
        `Email: ${email}\n` +
        `Tổng tiền: ${total.toLocaleString('vi-VN')} VND`;

    // Sử dụng thư viện qrcode.js
    const qr = qrcode(0, 'L');
    qr.addData(paymentData);
    qr.make();

    // Tạo thẻ <img> cho mã QR với kích thước lớn hơn
    const qrImageTag = qr.createImgTag(6); // Tăng giá trị từ mặc định (3) lên (6) để phóng to
    $('#qrCodeContainer').html(qrImageTag);

    // Thêm CSS để kiểm soát kích thước (nếu cần thiết)
    $('#qrCodeContainer img').css({
        width: '300px',  // Chiều rộng mã QR
        height: '300px' // Chiều cao mã QR
    });
}

    });
</script>

@endsection



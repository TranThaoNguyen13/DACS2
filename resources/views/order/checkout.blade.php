@extends('layouts.app')
<style>
    #qrCodeContainer img {
    width: 300px;
    height: 300px;
}
</style>
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<link rel="stylesheet" href="{{ asset('css/checkoutorder.css') }}">
<script src="https://cdn.jsdelivr.net/npm/qrcode@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/qrcode-generator/qrcode.min.js"></script>


<div class="container">
    <h2>Thanh toán đơn hàng</h2><br>
    <div class="row">
        <!-- Hình ảnh sản phẩm -->
        <div class="col-md-6">
            <img src="{{ asset('images/' . $order->product->image) }}" alt="{{ $order->product->name }}" class="img-fluid" style="border-radius: 15px;">
        </div>
        <div class="col-md-6">
            <h3><strong>{{ $order->product->name }}</strong></h3>
            <p><strong>Mã đơn hàng:</strong> {{ $order->id }}</p>
            <p><strong>Đơn giá:</strong> <span id="unitPrice">{{ number_format($order->product->new_price, 0, ',', '.') }}</span>.000 VND</p>
            <p><strong>Tổng giá trị đơn hàng:</strong> <span id="totalPrice">{{ number_format($order->total, 0, ',', '.') }}</span>.000 VND</p>

            <!-- Form thanh toán -->
            <form action="{{ route('order.processPayment', $order->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Số lượng:</label>
                    <div class="quantity-control d-flex align-items-center">
                        <button type="button" class="btn btn-sm btn-secondary decrement">-</button>
                        <input type="text" name="quantity" id="quantity" class="form-control text-center" value="1" style="width: 50px;" readonly>
                        <button type="button" class="btn btn-sm btn-secondary increment">+</button>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Họ tên:</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="address">Địa chỉ:</label>
                    <input type="text" name="address" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="phone">Số điện thoại:</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" required>
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


                <button type="submit" class="btn btn-primary">Xác nhận thanh toán</button>
                <button onclick="window.history.back()" class="btn btn-secondary">Quay lại</button>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        const unitPrice = {{ $order->product->new_price }};

        function updateTotalPrice() {
            const quantity = parseInt($('#quantity').val());
            const totalPrice = unitPrice * quantity;
            $('#totalPrice').text(totalPrice.toLocaleString('vi-VN'));
        }

        // Xử lý nút tăng số lượng
        $('.increment').on('click', function () {
            let quantity = parseInt($('#quantity').val());
            $('#quantity').val(quantity + 1);
            updateTotalPrice();
        });

        // Xử lý nút giảm số lượng
        $('.decrement').on('click', function () {
            let quantity = parseInt($('#quantity').val());
            if (quantity > 1) {
                $('#quantity').val(quantity - 1);
                updateTotalPrice();
            }
        });

        // Khi chọn phương thức thanh toán MoMo
        $('#payment_method').on('change', function () {
            const paymentMethod = $(this).val();
            if (paymentMethod === 'card') {
                // Hiển thị mã QR
                $('#momoQRCode').show();
                generateQRCode(); // Gọi hàm tạo mã QR
            } else {
                // Ẩn mã QR
                $('#momoQRCode').hide();
            }
        });

        function generateQRCode() {
            const username = $("input[name='username']").val();
            const address = $("input[name='address']").val();
            const phone = $("input[name='phone']").val();
            const email = $("input[name='email']").val();
            const quantity = $('#quantity').val();

            if (!username || !address || !phone || !email) {
                alert('Vui lòng nhập đầy đủ thông tin!');
                return;
            }

            // Chuẩn bị dữ liệu thanh toán
            const paymentData = `Mã đơn hàng: {{ $order->id }}\n` +
                `Sản phẩm: {{ $order->product->name }}\n` +
                `Số lượng: ${quantity}\n` +
                `Tổng tiền: {{ number_format($order->total, 0, ',', '.') }} VND\n` +
                `Người nhận: ${username}\n` +
                `Địa chỉ: ${address}\n` +
                `SĐT: ${phone}\n` +
                `Email: ${email}`;

            // Tạo mã QR
            const qr = qrcode(0, 'L');
            qr.addData(paymentData);
            qr.make();

            // Hiển thị mã QR
            $('#qrCodeContainer').html(qr.createImgTag());
        }
    });
</script>


@endsection

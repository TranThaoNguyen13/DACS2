@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<link rel="stylesheet" href="{{ asset('css/checkoutorder.css') }}">
<script src="https://cdn.jsdelivr.net/npm/qrcode@latest"></script>

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
            <p><strong>Đơn giá:</strong> <span id="unitPrice">{{ number_format($order->product->new_price, 0, ',', '.') }}</span>000 VND</p>
            <p><strong>Tổng giá trị đơn hàng:</strong> <span id="totalPrice">{{ number_format($order->total, 0, ',', '.') }}</span>000 VND</p>

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
    $(document).ready(function() {
        const unitPrice = {{ $order->product->new_price }};
        
        function updateTotalPrice() {
            const quantity = parseInt($('#quantity').val());
            const totalPrice = unitPrice * quantity;
            $('#totalPrice').text(totalPrice.toLocaleString('vi-VN'));
        }

        // Xử lý nút tăng số lượng
        $('.increment').on('click', function() {
            let quantity = parseInt($('#quantity').val());
            $('#quantity').val(quantity + 1);
            updateTotalPrice();
        });

        // Xử lý nút giảm số lượng
        $('.decrement').on('click', function() {
            let quantity = parseInt($('#quantity').val());
            if (quantity > 1) {
                $('#quantity').val(quantity - 1);
                updateTotalPrice();
            }
        });

        // Khi chọn phương thức thanh toán MoMo
        $('#payment_method').on('change', function() {
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

    if (!username) {
        alert('Vui lòng nhập họ tên');
        return;
    }

    // Chuẩn bị dữ liệu thanh toán
    const paymentData = {
        orderId: "{{ $order->id }}",
        amount: "{{ $order->total }}",
        productName: "{{ $order->product->name }}",
        user: username
    };

    console.log('Dữ liệu thanh toán trước mã hóa:', paymentData);

    // Chuyển đối tượng thành chuỗi JSON
    const qrCodeData = JSON.stringify(paymentData);

    console.log('Dữ liệu mã QR:', qrCodeData);

    // Tạo mã QR
    QRCode.toCanvas(document.getElementById('qrCodeContainer'), qrCodeData, function(error) {
        if (error) {
            console.error('Lỗi tạo mã QR:', error);
            alert('Không thể tạo mã QR. Vui lòng thử lại!');
        } else {
            console.log('Mã QR đã được tạo thành công!');
        }
    });
}


    });
</script>

@endsection

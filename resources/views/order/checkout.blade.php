@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<link rel="stylesheet" href="{{ asset('css/checkoutorder.css') }}">
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

                

                <button type="submit" class="btn btn-primary">Xác nhận thanh toán</button>
                <button onclick="window.history.back()" class="btn btn-secondary">Quay lại</button>
            </form>
        </div>
    </div>
</div>
 <!-- Sản phẩm liên quan: Carousel -->
 <div id="categoryCarousel" class="carousel slide mt-5" data-ride="carousel" style="background-color: white; border-radius: 15px; height: auto;">
        <div class="carousel-inner">
            @foreach($relatedProducts->chunk(4) as $chunk)
                <div class="carousel-item @if($loop->first) active @endif">
                    <h2>Gợi ý cho bạn:</h2>
                    <div class="row">
                        @foreach($chunk as $product)
                            <div class="col-md-3">
                            <p class="text-danger discount-tag">-{{ round((($product->old_price - $product->new_price) / $product->old_price) * 100) }}%</p>
                                <div class="card">
                                    <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                                    <div class="card-body">
                                    <div class="row">
                            <div class="col-6">
                                <p class="text-danger">{{ number_format($product->new_price, 0, ',', '.') }}.000đ</p>
                            </div>
                            <div class="col-6 text-right">
                                <p class="text-muted" style="text-decoration: line-through;">{{ number_format($product->old_price, 0, ',', '.') }}.000đ</p>
                            </div>
                        </div>
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <div class="stars">
                                             @for ($i = 0; $i < 5; $i++)
                                                <span class="fa fa-star {{ $i < $product->rating ? 'checked' : '' }}"></span>
                                                 @endfor
                                                 @if($product->sold > 0)
    <span class="text-muted">Đã bán: {{ $product->sold }} lần</span>
@else
    <span class="text-muted">Chưa có lượt bán</span>
@endif
                                        </div>


                                        
                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Nút điều hướng trái/phải -->
        <a class="carousel-control-prev" href="#categoryCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: black; border-radius: 30px;"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#categoryCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: black; border-radius: 30px;"></span>
            <span class="sr-only">Next</span>
        </a>
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
    });
</script>
@endsection

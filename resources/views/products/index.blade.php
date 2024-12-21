@extends('layouts.app')

@section('content')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<!-- Tải jQuery đầy đủ -->
<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

<div class="container mt-4" id="dssp">
    <h2 class="card-title">{{ $category->name }}</h2><br>
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card d-flex flex-column">
                    <div class="position-relative">
                        <p class="text-danger discount-tag">-{{ round((($product->old_price - $product->new_price) / $product->old_price) * 100) }}%</p>
                        <a href="{{ route('product.detail', $product->id) }}">
                            <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        </a>
                    </div>
                    <div class="card-body d-flex flex-column flex-grow-1">
                        <div class="row">
                            <div class="col-6">
                                <p class="text-danger">{{ number_format($product->new_price, 0, ',', '.') }}.000đ</p>
                            </div>
                            <div class="col-6 text-right">
                                <p class="text-muted" style="text-decoration: line-through;">{{ number_format($product->old_price, 0, ',', '.') }}.000đ</p>
                            </div>
                        </div>
                        <a href="{{ route('product.detail', $product->id) }}">
                            <h5 class="card-title">{{ $product->name }}</h5>
                        </a>
                        <div class="stars">
                            @for ($i = 0; $i < 5; $i++)
                                <span class="fa fa-star{{ $i < $product->rating ? ' checked' : '' }}"></span>
                            @endfor
                            <span class="text-muted">{{ $product->sold }} đã bán</span>
                        </div>

                        <!-- Thêm phần thương hiệu -->
                        <!-- <div class="brand mt-2">
                            <strong>Thương hiệu:</strong> <span class="text-muted">{{ $product->brand }}</span>
                        </div> -->

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="quantity-control d-flex align-items-center">
                                <button class="btn btn-sm btn-secondary decrement">-</button>
                                <input type="text" class="form-control text-center quantity" value="1" style="width: 50px;" readonly>
                                <button class="btn btn-sm btn-secondary increment">+</button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <button class="btn btn-primary add-to-cart" data-id="{{ $product->id }}">+Giỏ</button>
                            <form action="{{ route('order.buy') }}" method="POST">
                                @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1"> <!-- Nếu có thông tin số lượng -->
                                    <button type="submit" class="btn btn-primary">Mua ngay</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Hiển thị phân trang -->
    <div class="d-flex justify-content-center mt-4">
        {!! $products->links('vendor.pagination.custom') !!}
    </div>
</div>
<button onclick="window.history.back()" class="btn btn-secondary">Quay lại</button>

<script>
    $(document).ready(function() {
        // Xử lý nút tăng số lượng
        $('.increment').on('click', function() {
            let quantityInput = $(this).siblings('.quantity');
            let currentQuantity = parseInt(quantityInput.val());
            quantityInput.val(currentQuantity + 1);
        });

        // Xử lý nút giảm số lượng
        $('.decrement').on('click', function() {
            let quantityInput = $(this).siblings('.quantity');
            let currentQuantity = parseInt(quantityInput.val());
            if (currentQuantity > 1) {
                quantityInput.val(currentQuantity - 1);
            }
        });

        // Xử lý khi thêm vào giỏ hàng
        $('.add-to-cart').on('click', function() {
            let productId = $(this).data('id');
            let quantity = $(this).closest('.card-body').find('.quantity').val(); // Tìm input quantity trong cùng card

            $.ajax({
                url: "{{ route('add.to.cart') }}", // Đường dẫn đến route xử lý thêm vào giỏ hàng
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    quantity: quantity
                },
                success: function(response) {
                    alert(response.success); // Hiển thị thông báo khi thêm vào giỏ hàng thành công
                    // Cập nhật giỏ hàng ở header nếu cần
                    $('#cart-count').text(response.cart_count); // Giả sử bạn có phần tử với id là cart-count
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert('Có lỗi xảy ra khi thêm vào giỏ hàng.');
                }
            });
        });
        
    });
    
    function removeFromCart(productId) {
        fetch(`/cart/remove/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.success); // Hiển thị thông báo thành công
                location.reload(); // Tải lại trang để cập nhật giỏ hàng
            }
        })
        .catch(error => console.error('Error:', error));
    }


</script>
@endsection

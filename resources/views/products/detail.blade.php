@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">

<div class="container" id="chitiet">
    <div class="row">
        <div class="col-md-6">
            <div class="position-relative">
                <p class="text-danger discount-tag position-absolute" style="top: 10px; left: 10px;">
                    -{{ round((($product->old_price - $product->new_price) / $product->old_price) * 100) }}%
                </p>
                <img src="{{ asset('images/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}">
            </div>
        </div>
        <div class="col-md-6">
            <br><br>
            <h2>{{ $product->name }}</h2><br><br>
            <p class="text-danger" style="font-size: 25px;">{{ number_format($product->new_price, 0, ',', '.') }}.000đ</p>
            <p class="text-muted" style="text-decoration: line-through; font-size: 20px;">{{ number_format($product->old_price, 0, ',', '.') }}.000đ</p>
            <div class="stars">
                @for ($i = 0; $i < 5; $i++)
                    <span class="fa fa-star{{ $i < $product->rating ? ' checked' : '' }}"></span>
                @endfor
            </div><br>
            <p style="font-size: 20px;">Mô tả: {!! $product->description !!}</p>

            <div class="quantity-control d-flex align-items-center mt-3">
                <button class="btn btn-secondary btn-sm decrement">-</button>
                <input type="text" class="form-control text-center mx-2 quantity" value="1" style="width: 50px;" readonly>
                <button class="btn btn-secondary btn-sm increment">+</button>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                            <button class="btn btn-primary add-to-cart" data-id="{{ $product->id }}">Giỏ hàng</button>
                            <form action="{{ route('order.buy') }}" method="POST">
                                @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1"> <!-- Nếu có thông tin số lượng -->
                                    <button type="submit" class="btn btn-primary">Mua hàng</button>
                            </form>
                        </div><br><br>
    <a onclick="window.history.back()" style="color: blue; font-size: 25px;"><---</a>


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
</div>

@endsection

@section('scripts')

<script>
    $(document).ready(function() {
       

        // Xử lý nút tăng số lượng
        $('.increment').on('click', function() {
            let quantityInput = $(this).siblings('.quantity');
            let currentQuantity = parseInt(quantityInput.val());
            quantityInput.val(currentQuantity + 1);
            console.log("New Quantity (after):", quantityInput.val());
        });

        // Xử lý nút giảm số lượng
        $('.decrement').on('click', function() {
            let quantityInput = $(this).siblings('.quantity');
            let currentQuantity = parseInt(quantityInput.val());
            if (currentQuantity > 1) {
                quantityInput.val(currentQuantity - 1);
                console.log("Decremented Quantity:", quantityInput.val());
            }
        });

        // Xử lý nút "Cart" thêm vào giỏ hàng
        $('.add-to-cart').on('click', function() {
            let productId = $(this).data('id');
            let quantity = $(this).closest('.quantity-control').find('.quantity').val(); // Sửa lại để tìm quantity chính xác

            $.ajax({
                url: "{{ route('add.to.cart') }}", // Đảm bảo route này tồn tại
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    quantity: quantity
                },
                success: function(response) {
                    alert(response.success); // Hiển thị thông báo khi thêm vào giỏ hàng thành công
                    $('#cart-count').text(response.cart_count); // Cập nhật số lượng giỏ hàng
                },
                error: function(xhr) {
                    
                    console.error("Error adding to cart:", xhr);
                    alert('Có lỗi xảy ra khi thêm vào giỏ hàng.');
                }
            });
        });
    });
   
</script>

@endsection
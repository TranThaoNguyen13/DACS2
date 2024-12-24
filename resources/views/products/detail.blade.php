@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
        </div>
        <div class="col-md-6">
        <h2>{{ $product->name }}</h2><br><br>
            <p class="text-danger" style="font-size: 25px;">{{ number_format($product->new_price, 0, ',', '.') }}.000đ</p>
            <p class="text-muted" style="text-decoration: line-through; font-size: 20px;">{{ number_format($product->old_price, 0, ',', '.') }}.000đ</p>
            <div class="stars">
                @for ($i = 0; $i < 5; $i++)
                    <span class="fa fa-star{{ $i < $product->rating ? ' checked' : '' }}"></span>
                @endfor
            </div><br>
            <p style="font-size: 20px;">Mô tả: {!! $product->description !!}</p>
            <div class="quantity-controls">
                <button id="decrease" class="btn btn-secondary">-</button>
                <input id="quantity" type="number" value="1" min="1" class="form-control d-inline-block" style="width: 60px;">
                <button id="increase" class="btn btn-secondary">+</button>
            </div>
            <div class="d-flex">
    <!-- Nút Thêm vào giỏ hàng -->
    <button id="add-to-cart" class="btn btn-primary mt-3 mr-2">Thêm vào giỏ hàng</button>
    
    <!-- Form Mua ngay -->
    <form action="{{ route('order.buy') }}" method="POST" class=" btn btn-primary mt-3 mr-2mt-3 mr-2">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="quantity" value="1"> <!-- Nếu có thông tin số lượng -->
        <button type="submit" class="btn btn-primary" >Mua ngay</button>
    </form>
</div>

                            <div>
            <button onclick="window.history.back()" class="btn btn-primary mt-3">Quay lại trang chủ</button>
            </div>
        </div>
       

    </div>
</div>
<div class="mt-5">
    <h4>Bình luận</h4>

    <!-- Hiển thị danh sách bình luận -->
    @if($product->comments->count() > 0)
        @foreach($product->comments as $comment)
            <div class="border-bottom mb-3 pb-2 comment-item">
                <p class="comment-user"><strong>{{ $comment->user->username }}</strong></p>
                <p class="comment-content">{{ $comment->content }}</p>
                <p class="comment-time text-muted">{{ $comment->created_at->diffForHumans() }}</p>

                <!-- Hiển thị các câu trả lời của admin -->
                @foreach($comment->replies as $reply)
                    <div class="ml-4 border-top pt-2">
                        <p><strong>Admin:</strong> <span class="text-muted">{{ $reply->created_at->diffForHumans() }}</span></p>
                        <p>{{ $reply->content }}</p>
                    </div>
                @endforeach

                <!-- Form trả lời bình luận (dành cho admin) -->
                @auth
                    @if(auth()->user()->role === 'admin') <!-- Kiểm tra nếu là admin -->
                        <form action="{{ route('comment.reply', $comment->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <textarea name="content" class="form-control" rows="3" placeholder="Trả lời bình luận..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Gửi</button>
                        </form>
                    @endif
                    @if($comment->reply)
                <div class="admin-reply mt-3">
                    <strong>Nguyên Nhung trả lời:</strong>
                    <p>{{ $comment->reply }}</p>
                </div>
            @endif
                @endauth
            </div>
        @endforeach
    @else
        <p>Chưa có bình luận nào.</p>
    @endif

    <!-- Form thêm bình luận mới -->
    @auth
        <form action="{{ route('product.comment', $product->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <textarea name="content" class="form-control" rows="3" placeholder="Viết bình luận..."></textarea>
            
            <button type="submit" class="btn btn-primary mt-2">Gửi</button>
            </div>
        </form>
    @else
        <p><a href="{{ route('login') }}">Đăng nhập</a> để bình luận.</p>
    @endauth
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const decreaseButton = document.getElementById('decrease');
    const increaseButton = document.getElementById('increase');
    const quantityInput = document.getElementById('quantity');
    const addToCartButton = document.getElementById('add-to-cart');

    // Xử lý nút tăng/giảm số lượng
    decreaseButton.addEventListener('click', () => {
        let quantity = parseInt(quantityInput.value);
        if (quantity > 1) {
            quantityInput.value = quantity - 1;
        }
    });

    increaseButton.addEventListener('click', () => {
        let quantity = parseInt(quantityInput.value);
        quantityInput.value = quantity + 1;
    });

    // Xử lý thêm vào giỏ hàng
    addToCartButton.addEventListener('click', async () => {
        const quantity = parseInt(quantityInput.value);

        try {
            const response = await fetch('{{ route("add.to.cart") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    product_id: {{ $product->id }},
                    quantity: quantity,
                }),
            });

            if (response.ok) {
                const result = await response.json();
                if (result.success) {
                    alert(result.success);
                } else if (result.error) {
                    alert(result.error);
                }
            } else {
                alert('Đã xảy ra lỗi khi thêm vào giỏ hàng.');
            }
        } catch (error) {
            console.error('Lỗi:', error);
            alert('Đã xảy ra lỗi không xác định.');
        }
    });
});

</script>
@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Sản phẩm của thương hiệu {{ $brand->name }}</h1>

        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-3">
                    <div class="card">
                        <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p>{{ $product->price }} VNĐ</p>
                            <a href="{{ route('product.detail', ['id' => $product->id]) }}" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            @endforeach
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
@endsection

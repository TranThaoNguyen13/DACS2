@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<div class="slide">
<div class="container mt-4">
    <!-- Slideshow -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-bs-interval="3000">

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/ra99j40z.png" class="d-block w-100" alt="Slide 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Khuyến mãi mùa đông</h5>
                    <p>Những sản phẩm tốt nhất cho mùa đông này.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/uu31k01i.png" class="d-block w-100" alt="Slide 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Sản phẩm mới</h5>
                    <p>Khám phá bộ sưu tập sản phẩm mới nhất.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/mq3eo17u.png" class="d-block w-100" alt="Slide 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Giảm giá lên tới 50%</h5>
                    <p>Các sản phẩm hàng đầu đang được giảm giá!</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    
    <div class="icon-section">
        <div class="icon-item">
            <img src="images/quà.png" alt="Mua là có quà">
            <p>Mua là có quà</p>
        </div>
        <div class="icon-item">
            <img src="images/cẩm nang.png" alt="Cẩm nang">
            <p>Cẩm nang</p>
        </div>
        <div class="icon-item">
            <img src="images/clinic.png" alt="Clinic & Spa">
            <p>Clinic & Spa</p>
        </div>
        <div class="icon-item">
            <img src="images/đặt hẹn.png" alt="Đặt hẹn">
            <p>Đặt hẹn</p>
        </div>
        <div class="icon-item">
            <img src="images/now2h.png" alt="Giao hàng 2h">
            <p><a href="{{ route('icon.now2h') }}">Giao hàng 2h</a></p>
        </div>
        <div class="icon-item">
            <img src="images/nước hoa.png" alt="Nước hoa chính hãng">
            <p>Nước hoa chính hãng</p>
        </div>
    
</div>

</div>
</div>

    <section id="danh-muc">
    <div class="container mt-4" id="danhmuc">
    <h1>Danh mục</h1>
    <div id="categoryCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
        <div class="carousel-inner">
            @if($categories->isEmpty())
                <p>Không có danh mục nào.</p>
            @else
                @foreach ($categories->chunk(5) as $chunkIndex => $categoryChunk) <!-- Thay đổi từ chunk(4) thành chunk(5) -->
                    <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                        <div class="row g-0">
                            @foreach ($categoryChunk as $index => $category)
                                <div class="col-md-2"> <!-- Thay đổi từ col-md-3 thành col-md-2 -->
                                    <a href="{{ route('products.index.by.category', ['categoryId' => $category->id]) }}">
                                        <div class="card category-card category-{{ ($index % 8) + 1 }}">
                                            <img src="{{ asset('images/' . $category->image) }}" class="card-img-top" alt="{{ $category->name }}">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $category->name }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        

        <!-- Nút điều hướng trái/phải -->
        <a class="carousel-control-prev" href="#categoryCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#categoryCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>
</section>


@if(isset($results))
    <h2>Kết quả tìm kiếm cho: "{{ $search }}"</h2>
    
    @foreach($results as $type => $items)
        @if(count($items) > 0)
            <h3>{{ ucfirst($type) }}</h3>
            <div class="row">
                @foreach($items as $item)
                    <div class="col-md-4">
                        <div class="item-card">
                            <h5>{{ $item->name ?? $item->title }}</h5>
                            <p>{{ $item->description ?? $item->content }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach
@elseif(isset($search))
    <p>Không có kết quả nào cho "{{ $search }}"</p>
@endif

</div>
</div>
</div>

<div class="container mt-4">
<div class="image-sale">
    <div class="col-md-4">
        <img src="images/ảnh1.jpg" alt="logo">
    </div>
    <div class="col-md-4">
        <img src="images/ảnh2.jpg" alt="logo">
    </div>
    <div class="col-md-4">
        <img src="images/ảnh3.jpg" alt="logo">
    </div>
</div>
</div>
<section id="thuong-hieu">
<div class="container mt-4" id="thuonghieu">
    <h1>Thương hiệu</h1>
    <div id="brandCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
        <div class="carousel-inner">
            @if($brands->isEmpty())
                <p>Không có thương hiệu nào.</p>
            @else
                @foreach ($brands->chunk(5) as $chunkIndex => $brandChunk)
                    <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                        <div class="d-flex flex-row justify-content-center">
                            @foreach ($brandChunk as $brand)
                                <a href="{{ route('products.by.brand', ['brandId' => $brand->id]) }}" class="text-decoration-none">
                                    <div class="card brand-card mx-2">
                                        <img src="{{ asset('images/' . $brand->image) }}" class="card-img-top" alt="{{ $brand->name }}">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">{{ $brand->name }}</h5>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        
        <!-- Nút điều hướng trái/phải -->
        <a class="carousel-control-prev" href="#brandCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true" id="next"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#brandCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true" id="previous"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

</div>
</section>

<section id="ban-chay">
    <div class="container mt-4">
        

        <div id="categoryCarousel" class="carousel slide" data-ride="carousel">
        <h5>Bán chạy</h5>
            <div class="carousel-inner">
                @foreach ($bestSellers->chunk(4) as $chunk)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="row">
                            @foreach ($chunk as $product)
                                <div class="col-md-3">
                                    <div class="card mb-4">
                                        <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}"><br>
                                        <div class="card-title"><b>{{ $product->name }}</b></div>
                                        <span class="sold-count">{{ $product->sold }} đã bán</span>
                                        <div class="card-body">
                                            <p class="new-price">{{ $product->new_price }}.000 VNĐ</p>
                                            <p class="old-price">{{ $product->old_price }}.000 VNĐ</p>
                                            <div class="stars">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <span class="fa fa-star{{ $i < $product->rating ? ' checked' : '' }}"></span>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Carousel Controls -->
            <a class="carousel-control-prev" href="#categoryCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#categoryCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</section>





<!-- @foreach ($brands as $brand)
    <p>{{ $brand->name }}</p>
@endforeach -->
@if(session('success'))
    <div class="alert alert-success mt-4">
        {{ session('success') }}
    </div>
@endif



@if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif
<script>
    $(document).ready(function(){
        $('.carousel').carousel();
    });
</script>


@endsection

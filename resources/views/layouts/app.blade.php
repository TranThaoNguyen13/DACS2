<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>@yield('title')</title>
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>
<body>



   
   


<header>
    <div class="container-fluid">
        <!-- Social Links -->
        <div class="row align-items-center mb-2">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <span class="me-2">Follow us:</span>
                    <a href="https://www.facebook.com/nguyen.nhi.nho.1306/" class="fab fa-facebook me-2"></a>
                    <a href="#" class="fab fa-youtube me-2"></a>
                    <a href="https://www.instagram.com/13th06.ng/" class="fab fa-instagram me-2"></a>
                    <a href="#" class="fab fa-tiktok"></a>
                </div>
            </div>
        </div>

        <!-- Logo, Search Bar, Links -->
        <div class="row align-items-center">
            <div class="col-md-3">
            <img src="{{ asset('images/NguyênNhung(1)(1).png') }}" alt="Nguyen Nhung" style="width: 250px">
            </div>
            <div class="col-md-5">
            <form action="{{ route('home.search') }}" method="GET" class="d-flex">
    <input type="search" id="search-bar" name="search" class="form-control me-2" placeholder="Tìm kiếm...">
    <button class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
</form>


            </div>
            <div class="col-md-4 text-end">
    <a href="{{ route('stores.index') }}" class="me-3">
        <img src="{{ asset('images/icons8-shop-48.png') }}" alt="Nguyen Nhung" style="width:30px;"> Hệ thống cửa hàng
    </a>
    <a href="{{ route('support.support_customer') }}" class="me-3">
        <img src="{{ asset('images/icons8-ringer-volume-50.png') }}" alt="Nguyen Nhung" style="width:30px;"> Hỗ trợ khách hàng
    </a>
</div>
        </div>

        <!-- Navigation Bar -->
         <nav>
        <div class="row align-items-center mt-3">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a href="#danh-muc" class="nav-link">DANH MỤC</a></li>
                            <li class="nav-item"><a href="#" class="nav-link">NN DEALS</a></li>
                            <li class="nav-item"><a href="{{ route('hot_deals') }}" class="nav-link">HOT DEALS</a></li>
                            <li class="nav-item"><a href="#thuong-hieu" class="nav-link">THƯƠNG HIỆU</a></li>
                            <li class="nav-item"><a href="#" class="nav-link">HÀNG MỚI VỀ</a></li>
                            <li class="nav-item"><a href="#" class="nav-link">BÁN CHẠY</a></li>
                            <li class="nav-item"><a href="#" class="nav-link">CLINIC & SPA</a></li>
                        </ul>
                    </div>
                    <div class="icons d-flex align-items-center ms-3">
                    <a href="{{ route('order.history') }}">Tra cứu đơn hàng |</a>
                        
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                         @csrf
                    </form>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất |</a>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng nhập |</a>
                        
                        </div><a href="{{ route('cart.index') }}" class="position-relative" id="cart">
                            <i class="fas fa-shopping-cart" style="font-size: 20px;"></i>
                             @php
                                $cartCount = session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0;
                             @endphp
                            @if ($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                 {{ $cartCount }}
                                    <span class="visually-hidden">Số sản phẩm trong giỏ hàng</span>
                                </span>
                            @endif
                        </a>
                        <a href="#"> </a>
                        <a href="#" class="fas fa-heart me-3"></a>
                        
                    </div>
                </nav>
            </div>
        </div>
    </div>
</nav>
</header>

<!-- Bootstrap JS -->
<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

</body>
</html>


    <div class="container mt-4">
        @yield('content')
    </div>
    <footer>
    <form action="last">
    <div class="line"></div>
    <div class="last-container container my-4">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-3">
                <a href="#"><img src="{{ asset('images/9vv4lgct.png') }}" alt="Nguyen Nhung" style="width: 76%;"></a>
                <a href="#"><h3>Thanh toán khi nhận hàng</h3></a>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <a href="#"><img src="{{ asset('images/v17s3bcl.png') }}" alt="Nguyen Nhung" style="width: 100%;"></a>
                <a href="#"><h3>Giao hàng miễn phí</h3></a>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <a href="#"><img src="{{ asset('images/Icon-Doi-Tra-Hang.jpg') }}" alt="Nguyen Nhung" style="width: 80%;"></a>
                <a href="#"><h3>Đổi trả miễn phí</h3></a>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <a href="#"><img src="{{ asset('images/fvi1ydj3.png') }}" alt="Nguyen Nhung" style="width: 87%;"></a>
                <a href="#"><h3>Thương hiệu chính hãng</h3></a>
            </div>
        </div>
    </div>
    
    <div class="hotline container my-4">
        <div class="row">
            <!-- Customer Support -->
            <div class="col-lg-3 col-md-6 mb-3">
                <h3>HỖ TRỢ KHÁCH HÀNG</h3>
                <a href="#" style="color: red;">Hotline: <b>0337083294</b></a><br>
                <small>(miễn phí, 08-22h kể cả T7,CN)</small><br>
                <a href="#">Các câu hỏi thường gặp</a><br>
                <a href="#">Gửi yêu cầu hỗ trợ</a><br>
                <a href="#">Hướng dẫn đặt hàng</a><br>
                <a href="#">Phương thức vận chuyển</a><br>
                <a href="#">Chính sách đổi trả</a><br>
            </div>
            
            <!-- About Us -->
            <div class="col-lg-3 col-md-6 mb-3">
                <h3>VỀ CHÚNG TÔI</h3>
                <a href="#">Giới thiệu</a><br>
                <a href="#">Tuyển dụng</a><br>
                <a href="#">Chính sách bảo mật</a><br>
                <a href="#">Điều khoản sử dụng</a><br>
                <a href="#">Liên hệ</a><br>
                <a href="#">Tư vấn khách hàng</a>
            </div>
            
            <!-- Partnerships -->
            <div class="col-lg-3 col-md-6 mb-3">
                <h3>HỢP TÁC VÀ LIÊN KẾT</h3>
                <a href="http://127.0.0.1:5500/website/Trang%20chu.html#">Trang chủ</a><br>
                <a href="#">Cẩm nang</a><br>
                <div class="lienhe d-flex justify-content-between mt-2">
                    <a href="https://www.facebook.com/nguyen.nhi.nho.1306/"><img src="{{ asset('images/facebook.png') }}" alt="Nguyen Nhung" "></a>
                    <a href="#"><img src="{{ asset('images/youtube.png') }}" alt="Nguyen Nhung"></a>
                    <a href="https://www.instagram.com/13th06.ng/" ><img src="{{ asset('images/instagram.png') }}" alt="Nguyen Nhung"></a>
                </div>
                <h3 class="mt-4">THANH TOÁN</h3>
                <div class="thanhtoan d-flex justify-content-between">
                    <a href="#"><img src="{{ asset('images/visa.png') }}" alt="Visa" style="width:20px;"></a>
                    <a href="#"><img src="{{ asset('images/atm-card.png') }}" alt="ATM Card" style="width:20px;"></a>
                </div>
            </div>
            
            <!-- Newsletter -->
            <div class="col-lg-3 col-md-6 mb-3">
                <h3>CẬP NHẬT THÔNG TIN KHUYẾN MÃI</h3>
                <div class="d-flex align-items-center mt-2">
        <input type="email" class="form-control me-2" placeholder="Nhập email của bạn" style="width: 170px;">
        <button class="mt-2">Cập nhật</button>
    </div>
                <h3 class="mt-4">KHIẾU NẠI GÓP Ý</h3>
                <button>0337083294</button>
            </div>
        </div>
    </div>
</form>
    </footer>
    @if (session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif


    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</body>
</html>

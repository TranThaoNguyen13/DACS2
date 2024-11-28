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
    <link rel="stylesheet" href="{{ asset('css/app2.css') }}">
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>
<body>




   
   


<header>
    <div class="container-fluid">
        <!-- Social Links -->

        <!-- Logo, Search Bar, Links -->
        <div class="row align-items-center">
            <div class="col-md-6">
            <img src="{{ asset('images/NguyênNhung(1)(1).png') }}" alt="Nguyen Nhung" style="width: 250px">
            </div>
            
            <div class="col-md-6 text-end">
    <a href="{{ route('stores.index') }}" class="me-3">
         Gửi yêu cầu |
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                         @csrf
                    </form>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất </a>
</div>
        </div>

        <!-- Navigation Bar -->
        
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
                <div class="lienhe mt-2">
                    <a href="https://www.facebook.com/nguyen.nhi.nho.1306/"><img src="{{ asset('images/facebook.png') }}" alt="Nguyen Nhung" "></a>
                    <a href="#"><img src="{{ asset('images/youtube.png') }}" alt="Nguyen Nhung"></a>
                    <a href="https://www.instagram.com/13th06.ng/" ><img src="{{ asset('images/instagram.png') }}" alt="Nguyen Nhung"></a>
                </div>
                <h3 class="mt-4">THANH TOÁN</h3>
                <div class="thanhtoan">
                    <a href="#"><img src="{{ asset('images/visa.png') }}" alt="Visa" style="width:20px;"></a>
                    <a href="#"><img src="{{ asset('images/atm-card.png') }}" alt="ATM Card" style="width:20px;"></a>
                </div>
            </div>
            
            <!-- Newsletter -->
            <div class="col-lg-3 col-md-6 mb-3">
                <h3>CẬP NHẬT THÔNG TIN KHUYẾN MÃI</h3>
                <input type="email" class="form-control mt-2" placeholder="Nhập email của bạn">
                <button class="mt-2">Cập nhật</button>
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

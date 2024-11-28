@extends('layouts.app2')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/support.css') }}">
<nav>
    <a href="#" onclick="window.history.back()" id="home">Trang chủ </a>> Hỗ trợ khách hàng <br><br><br>
</nav>
<br><br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <a href="#"><img src="images/icon user.png" alt="tk">Tài khoản</a>
        </div>
        <div class="col-md-2">
            <a href="#"><img src="images/icon vận chuyển.png" alt="tk">Vận chuyển</a>
        </div>
        <div class="col-md-2">
            <a href="#"><img src="images/icon order.png" alt="tk">Đặt hàng</a>
        </div>
        <div class="col-md-2">
            <a href="#"><img src="images/phí vận chuyển.png" alt="tk">Phí vận chuyển</a>
        </div>
        <div class="col-md-2">
            <a href="#"><img src="images/icon spa.png" alt="tk">CLINIC & SPA</a>
        </div>
        <div class="col-md-2">
            <a href="#"><img src="images/icon return.png" alt="tk">Đổi trả/Hoàn tiền</a>
        </div>
    </div>
</div><br><br>
<div class="container-fluid">
    <div class="row">
        <h5>Câu hỏi thường gặp</h5>
        <div class="col-md-6">
            <ul>
                <li><a href="#">Đăng ký thành viên như thế nào?</a></li>
                <li><a href="#">Tại sao tôi không thể đăng nhập vào tài khoản của tôi</a></li>
                <li><a href="#">Tôi có thể sử dụng chung tài khoản vớ người khác không?</a></li>

            </ul>
            
        </div>
        <div class="col-md-6">
            <ul>
                <li><a href="#">Có cần đặt lịch trước khi đến spa không??</a></li>
                <li><a href="#">Đặt dịch vụ như thế nào?</a></li>
                <li><a href="#">Khám da tại Spa NN-Cosmetics có tốn phí không?</a></li>
                
            </ul>
        </div>
    </div>
</div><br><br><br><br>
<div class="container-fluid">
    <div class="row">
        <h5>Thông tin hỗ trợ</h5>
        <div class="col-md-3">
            <ul>
                <li><a href="#">Giới thiệu NN-Cosmetics</a></li>
                <li><a href="#">Hướng dẫn đặt hàng 2h</a></li>
                <li><a href="#">Chính sách vẫn chuyển giao nhận</a></li>

            </ul>
            
        </div>
        <div class="col-md-3">
            <ul>
                <li><a href="#">Khách hàng thân thiết</a></li>
                <li><a href="#">Hướng dẫn thanh toán trực tuyến</a></li>
                <li><a href="#">Điều khoản sử dụng</a></li>
                
            </ul>
        </div>
        <div class="col-md-3">
            <ul>
                <li><a href="#">Hướng dẫn đặt hàng</a></li>
                <li><a href="#">Phiếu mua hàng</a></li>
                <li><a href="#">Hướng dẫn tải và sử dụng app NN</a></li>

            </ul>
            
        </div>
        <div class="col-md-3">
            <ul>
                <li><a href="#">Hướng dẫn đổi quà</a></li>
                <li><a href="#">Thẻ quà tặng Got It</a></li>
                <li><a href="#">Chính sách bảo mật</a></li>
                
            </ul>
        </div>
    </div><br><br><br>
</div>
@endsection

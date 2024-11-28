@extends('layouts.app')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hot Deals</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
    }
    .container {
        max-width: 1200px;
    }
    .row {
        margin-top: 20px;
    }
    img {
        
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    img:hover {
        transform: scale(1.05);
        
    }
    p {
        text-align: center;
        font-size: 16px;
        font-weight: 500;
        margin-top: 10px;
        color: red;
        font-style: bold;
    }
    p:hover {
        color: black;
        transition: color 0.3s ease;
    }
    h2 {
        font-size: 28px;
        font-weight: bold;
        color: #007bff;
        text-align: center;
        margin-bottom: 20px;
    }
</style>

<body>

    <a href="#" onclick="window.history.back()" id="home">Trang chủ </a>> Hỗ trợ khách hàng <br><br><br>

    <div class="container my-4">
        <div class="row g-3">
            <!-- Bắt đầu thêm hình -->
            <div class="col-md-6">
                <img src="images/hinh1.jpg" class="img-fluid rounded" alt="Image 1">
                <p>25.11 SALE CUỐI THÁNG SĂN DEALS XẢ LÁNG</p>
            </div>
            <div class="col-md-6">
                <img src="images/hinh2.jpg" class="img-fluid rounded" alt="Image 2">
                <p>KHAI TRƯƠNG CHI NHÁNH MỚI</p>
            </div>
            <div class="col-md-6">
                <img src="images/hinh3.jpg" class="img-fluid rounded" alt="Image 3">
                <p>12.12 ĐĂNG KÝ NHẬN QUÀ </p>
            </div>
            <div class="col-md-6">
                <img src="images/hinh4.jpg" class="img-fluid rounded" alt="Image 4">
                <p>12.12 NN-COSMETICS OMNI-CHANNEL DAY</p>
            </div>
            <div class="col-md-6">
                <img src="images/hinh5.jpg" class="img-fluid rounded" alt="Image 5">
                <p>HOT! ƯU ĐÃI TRẢI NGHIỆM LÀM ĐẸP ĐẾN 60%</p>
            </div>
            <div class="col-md-6">
                <img src="images/hinh6.jpg" class="img-fluid rounded" alt="Image 6">
                <p>TRẢI NGHIỆM TRIỆT LÔNG NAM DIODE LAZER 99K</p>
            </div>
            <div class="col-md-6">
                <img src="images/hinh7.jpg" class="img-fluid rounded" alt="Image 7">
                <p>SALE LƯƠNG VỀ - DEALS NGẬP TRÀN</p>
            </div>
            <div class="col-md-6">
                <img src="images/hinh8.png" class="img-fluid rounded" alt="Image 8">
                <p>UNILEVER NÂNG NIU NÉT ĐẸP TOÀN DIỆN</p>
            </div>
            <div class="col-md-6">
                <img src="images/hinh13.jpg" class="img-fluid rounded" alt="Image 9">
                <p>LÀM ĐẸP CÔNG NGHỆ CAO CHỈ TỪ 1200K</p>
            </div>
            <div class="col-md-6">
                <img src="images/hinh8.jpg" class="img-fluid rounded" alt="Image 10">
                <p>DƯỢC MỸ PHẨM - GIẢI PHÁP CHO MỌI LÀN DA</p>
                
            </div>
            <div class="col-md-6">
                <img src="images/hinh9.jpg" class="img-fluid rounded" alt="Image 11">
                <p>ĐẠI TIỆC TREATMENT - CHĂM DA CHUYÊN SÂU</p>
                
            </div>
            <div class="col-md-6">
                <img src="images/hinh10.jpg" class="img-fluid rounded" alt="Image 12">
                <p>MỸ PHẨM ÂU MỸ - GIẢM THẦN SẦU</p>
                
            </div>
            <div class="col-md-6">
                <img src="images/hinh11.jpg" class="img-fluid rounded" alt="Image 13">
                <p>CHĂM SÓC CHO NAM</p>
            </div>
            <div class="col-md-6">
                <img src="images/hinh12.jpg" class="img-fluid rounded" alt="Image 14">
                <p>MILAGANICS, BODYMISS, CỎ MỀM, MELA</p>
            </div>
        </div>
    </div>

    <!-- Link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
@endsection

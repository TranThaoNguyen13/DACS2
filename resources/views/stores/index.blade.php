@extends('layouts.app2')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/stores.css') }}">
<nav>
    <a href="#" onclick="window.history.back()" id="home">Trang chủ ></a> Hệ thống cửa hàng <br><br><br>
</nav>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar hỗ trợ khách hàng -->
        <div class="col-md-3 sidebar">
            <h4>Hỗ Trợ Khách Hàng</h4>
            <ul class="list-unstyled">
                <li><a href="#">Giới thiệu NN-Cosmetics</a></li>
                <li><a href="#">Liên hệ</a></li>
                <li><a href="#">Tuyển dụng</a></li>
                <li><a href="#">Chính sách bảo mật</a></li>
                <li><a href="#">Điều khoản sử dụng</a></li>
                <li><a href="#">Hướng dẫn đặt hàng</a></li>
                <li><a href="#">Hướng dẫn đặt hàng 2h</a></li>
                <li><a href="#">Phương thức thanh toán</a></li>
                <li><a href="#">Chính sách giao nhận</a></li>
                <li><a href="#">Khách hàng thân thiết</a></li>
                <li><a href="#">Tích điểm đổi quà</a></li>
                <li><a href="#">Hướng dẫn nhận quà</a></li>
                <li><a href="#">Thẻ quà tặng Got It</a></li>
                <li><a href="#">Phiếu mua hàng NN-Cosmetics</a></li>
                <li><a href="#">Chính sách Cookie</a></li>
                <li><a href="#">Quy định giao dịch chung</a></li>
            </ul>
        </div>

        <!-- Danh sách cửa hàng -->
        <div class="col-md-3">
            <h4>Danh Sách Cửa Hàng</h4>
            <ul class="list-group">
                @php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "nn-cosmetics";
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    
                    if ($conn->connect_error) {
                        die("Kết nối thất bại: " . $conn->connect_error);
                    }

                    $sql = "SELECT name, address, map_url FROM stores";
                    $result = $conn->query($sql);

                    if (!$result) {
                        die("Lỗi truy vấn: " . $conn->error);
                    }
                @endphp
                
                @if ($result->num_rows > 0)
                    @while ($row = $result->fetch_assoc())
                        <li class="list-group-item">
                            <a href="#" onclick="changeMap('{{ $row['map_url'] }}')">{{ $row['name'] }}</a>
                        <p>Địa chỉ: {{ $row['address'] }}</p>
                        </li>   
                    @endwhile
                @else
                    <p>Không có cửa hàng nào.</p>
                @endif
                
                @php $conn->close(); @endphp
            </ul>
        </div>

        <!-- Google Map hiển thị vị trí cửa hàng -->
        <div class="col-md-6">
            <h4>Vị Trí Cửa Hàng</h4>
            <div class="map-container">
                <iframe id="store-map" src="https://www.google.com/maps/embed?pb=..." width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    function changeMap(mapUrl) {
        document.getElementById('store-map').src = mapUrl;
    }
</script>

@endsection

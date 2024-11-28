@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/now2h.css') }}">
<nav>
    <a href="#" onclick="window.history.back()" id="home">Trang chủ </a>> Giao 2h <br><br><br>
</nav>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Dịch Vụ Giao Hàng 2H</h1>
        
        <div class="section">
            <h4>Now2H là gì?</h4>
            <p>
                Now2H là dịch vụ giao hàng nhanh miễn phí trong 2H của Hasaki nhằm đáp ứng nhu cầu nhận hàng nhanh trong ngày dành cho các khách hàng thuộc khu vực nội thành Cần Thơ, Dĩ An tỉnh Bình Dương, Biên Hòa tỉnh Đồng Nai, Hồ Chí Minh và Hà Nội.
            </p>
        </div>

        <div class="section">
            <h4>Điều kiện để được áp dụng NowFree - MIỄN PHÍ GIAO NHANH 2H?</h4>
            <ul>
                <li>Đơn hàng từ 90.000đ trở lên</li>
                <li>Địa chỉ đặt hàng ở Bến Tre, Đắk Lắk, Đà Nẵng, Tiền Giang, Kiên Giang, Cần Thơ, Bình Dương, Đồng Nai, Hồ Chí Minh và Hà Nội nằm trong khu vực có áp dụng NowFree.</li>
                <li>Sản phẩm trong giỏ hàng của quý khách phải có sẵn tại kho hàng gần nhất xử lý giao nhanh.</li>
            </ul>
        </div>

        <div class="section">
            <h4>Đối tượng sử dụng dịch vụ NowFree</h4>
            <p>
                Khách hàng ở các khu vực nội thành Thành Phố Buôn Ma Thuột tỉnh Đắk Lắk, Đà Nẵng, Thành phố Mỹ Tho tỉnh Tiền Giang, Rạch Giá tỉnh Kiên Giang, Cần Thơ, Dĩ An tỉnh Bình Dương, Biên Hòa tỉnh Đồng Nai, Hồ Chí Minh và Hà Nội.
            </p>
        </div>

        <div class="section">
            <h4>Mức phí áp dụng cho dịch vụ giao hàng 2H</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Điều kiện đơn hàng</th>
                        <th>Mức phí</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Đơn hàng từ 90.000đ</td>
                        <td>Miễn phí</td>
                    </tr>
                    <tr>
                        <td>Đơn hàng nhỏ hơn 90.000đ</td>
                        <td>10.000đ</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <h4>Khung giờ áp dụng dịch vụ giao hàng 2H</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Thời gian đặt hàng</th>
                        <th>Dự kiến nhận hàng</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Từ 00:01 - 08:00</td>
                        <td>Trước 10:00 cùng ngày</td>
                    </tr>
                    <tr>
                        <td>Từ 08:01 - 09:00</td>
                        <td>Trước 11:00 cùng ngày</td>
                    </tr>
                    <tr>
                        <td>Từ 09:01 - 10:00</td>
                        <td>Trước 12:00 cùng ngày</td>
                    </tr>
                    <tr>
                        <td>Từ 10:01 - 11:00</td>
                        <td>Trước 13:00 cùng ngày</td>
                    </tr>
                    <tr>
                        <td>Từ 11:01 - 12:00</td>
                        <td>Trước 14:00 cùng ngày</td>
                    </tr>
                    <tr>
                        <td>Từ 12:01 - 13:00</td>
                        <td>Trước 15:00 cùng ngày</td>
                    </tr>
                    <tr>
                        <td>Từ 13:01 - 14:00</td>
                        <td>Trước 16:00 cùng ngày</td>
                    </tr>
                    <tr>
                        <td>Từ 14:01 - 15:00</td>
                        <td>Trước 17:00 cùng ngày</td>
                    </tr>
                    <tr>
                        <td>Từ 15:01 - 16:00</td>
                        <td>Trước 18:00 cùng ngày</td>
                    </tr>
                    <tr>
                        <td>Từ 16:01 - 18:00</td>
                        <td>Trước 20:00 cùng ngày</td>
                    </tr>
                    <tr>
                        <td>Từ 18:01 - 00:00</td>
                        <td>Trước 10:00 ngày kế tiếp</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <h4>Hasaki giao hàng đến 18h từ thứ 2 đến Chủ Nhật</h4>
            <p>Tất cả các sản phẩm đăng bán trên website hasaki.vn đều được áp dụng dịch vụ giao hàng 2H.</p>
        </div>

        <div class="section">
            <h4>Chính sách đền bù đơn giao hàng trễ</h4>
            <p>Hasaki cam kết giao đúng hẹn. Nếu giao trễ, tặng ngay Phiếu Mua Hàng 100K.</p>
            <p><strong>Điều kiện nhận Phiếu Mua Hàng 100K:</strong> Đơn hàng của bạn là đơn giao bởi dịch vụ NowFree và giao trễ hơn thời gian dự kiến giao ban đầu.</p>
            <p><strong>Lưu ý:</strong> Hasaki miễn trừ trách nhiệm đền bù đối với các trường hợp bất khả kháng như dịch bệnh, thiên tai, chiến tranh, hỏa hoạn, tai nạn giao thông, cơ quan chức năng kiểm tra,...</p>
        </div>

        <div class="section">
            <h4>Điều kiện sử dụng Phiếu Mua Hàng 100K đền bù cho đơn giao trễ</h4>
            <p>Phiếu Mua Hàng 100K có thể sử dụng cho các dịch vụ tại Hasaki Clinic. Tuy nhiên, phiếu không thể chuyển nhượng cho tài khoản khác sử dụng.</p>
        </div>
    </div>
@endsection

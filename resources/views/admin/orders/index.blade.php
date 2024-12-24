@extends('layouts.admin')

@section('content')
    <style>
        /* Đặt tiêu đề bảng cố định ở trên cùng */
        .table thead th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa; /* Màu nền của tiêu đề */
            z-index: 1;
        }

        /* Tạo vùng cuộn cho bảng */
        .table-wrapper {
            max-height: 500px; /* Đặt chiều cao tối đa cho vùng cuộn */
            overflow-y: auto; /* Hiển thị thanh cuộn dọc khi có nhiều hơn số dòng */
            display: block;
        }

        .table {
            width: 100%;
            table-layout: fixed; /* Đảm bảo các cột có thể kiểm soát được độ rộng */
        }

        /* Đặt chiều rộng cho các cột */
        .table th, .table td {
            padding: 8px;
            text-align: center;
        }

        .table th:nth-child(1), .table td:nth-child(1) { /* Cột 'ID' */
            width: 5%;
        }
        .table th:nth-child(2), .table td:nth-child(2) { /* Cột 'ID Khách Hàng' */
            width: 10%;
        }
        .table th:nth-child(3), .table td:nth-child(3) { /* Cột 'Giá' */
            width: 10%;
        }
        .table th:nth-child(4), .table td:nth-child(4) { /* Cột 'Trạng thái' */
            width: 10%;
        }
        .table th:nth-child(5), .table td:nth-child(5) { /* Cột 'Tên khách hàng' */
            width: 15%;
        }
        .table th:nth-child(6), .table td:nth-child(6) { /* Cột 'Địa chỉ' */
            width: 15%;
        }
        .table th:nth-child(7), .table td:nth-child(7) { /* Cột 'Phương thức thanh toán' */
            width: 10%;
        }
        .table th:nth-child(8), .table td:nth-child(8) { /* Cột 'Số điện thoại' */
            width: 10%;
        }
        .table th:nth-child(9), .table td:nth-child(9) { /* Cột 'Email' */
            width: 15%;
        }
        .table th:nth-child(10), .table td:nth-child(10) { /* Cột 'ID Sản Phẩm' */
            width: 10%;
        }
        .table th:nth-child(11), .table td:nth-child(11) { /* Cột 'Số lượng' */
            width: 5%;
        }
        .table th:nth-child(12), .table td:nth-child(12) { /* Cột 'Hành động' */
            width: 15%;
        }
    </style>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Quản Lý Đơn Hàng</h1>
            <div class="d-flex">
                <!-- Thanh tìm kiếm -->
                <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex">
                    <input type="text" name="query" class="form-control me-2" placeholder="Tìm kiếm đơn hàng..." value="{{ request('query') }}">
                    <button type="submit" class="btn btn-primary">Tìm</button>
                </form>
            </div>
        </div>

        @if(session('success'))
<div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Bọc bảng trong div có class 'table-wrapper' để tạo vùng cuộn -->
        <div class="table-wrapper">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID Khách Hàng</th>
                        <th>Giá</th>
                        <th>Trạng thái</th>
                        <th>Tên khách hàng</th>
                        <th>Địa chỉ</th>
                        <th>Phương thức thanh toán</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>ID Sản Phẩm</th>
                        <th>Số lượng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user_id }}</td>
                            <td>{{ number_format($order->total, 0, ',', '.') }}.000đ</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->username }}</td>
                            <td>{{ $order->address }}</td>
                            <td>{{ $order->payment_method }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->product_id }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>
                                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning">Sửa</a>
                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
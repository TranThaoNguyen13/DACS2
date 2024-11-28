<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>
    <!-- Header -->
    <header class="bg-dark text-white py-3" style="height: 150px;">
        <div class="container d-flex justify-content-between align-items-center">
            <!-- Logo -->
            <a href="{{ route('admin.dashboard') }}" class="navbar-brand text-warning fw-bold">Admin Dashboard</a>
            
            <!-- Search Bar -->
            <form class="d-flex" action="{{ route('admin.search') }}" method="GET">
                <input class="form-control me-2" type="search" placeholder="Tìm kiếm..." name="query" required>
                <button class="btn btn-warning" style="background-color: pink;" type="submit">Tìm</button>
            </form>
            
            <!-- Logout Button -->
            <a href="#" class="btn btn-outline-light"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Đăng xuất
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </header>

    <!-- Body -->
    <div class="container-fluid mt-3">
        <div class="row">
            <!-- Sidebar (Thanh điều hướng) -->
            <nav class="col-md-3 col-lg-2 bg-light sidebar py-3">
                <ul class="nav flex-column">
                <li class="nav-item">
                <img src="{{ asset('images/NguyênNhung(1)(1).png') }}" alt="Nguyen Nhung" style="width: 230px">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.products.index') }}">Quản Lý Sản Phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.orders.index') }}">Quản Lý Đơn Hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.categories.index') }}">Quản Lý Danh Mục</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.brands.index') }}">Quản Lý Thương Hiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users.index') }}">Quản Lý Người Dùng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.nhanvien.index') }}">Quản Lý Nhân Viên</a>
                    </li>
                    
                </ul>
            </nav>

            <!-- Main Content (Nội dung chức năng) -->
            <main class="col-md-9 col-lg-10 px-4">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>

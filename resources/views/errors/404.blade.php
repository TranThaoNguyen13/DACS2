<!-- resources/views/errors/404.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Đường dẫn CSS nếu có -->
</head>
<body>
    <div style="text-align: center; margin-top: 50px;">
        <h1>404 - Page Not Found</h1>
        <p>Xin lỗi, trang bạn đang tìm không tồn tại.</p>
        <a href="{{ route('customer.home') }}">Trở về trang chủ</a> <!-- Link quay về trang chủ -->
    </div>
</body>
</html>

<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Kiểm tra xem ứng dụng có đang trong chế độ bảo trì hay không
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Đăng ký autoloading
require __DIR__ . '/../vendor/autoload.php';

// Khởi động ứng dụng
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Xử lý yêu cầu
$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
);

// Gửi phản hồi đến trình duyệt
$response->send();

// Kết thúc yêu cầu
$kernel->terminate($request, $response);

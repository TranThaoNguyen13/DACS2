<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function showHotDeals()
    {
        // Nếu có dữ liệu từ DB cần xử lý, thêm ở đây.
        return view('hot_deals'); // Hiển thị view hot-deals.blade.php
    }
}

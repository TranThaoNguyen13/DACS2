<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
{
    $query = $request->input('query');

    // Kiểm tra nếu không có từ khóa tìm kiếm
    if (!$query) {
        return redirect()->back()->with('error', 'Vui lòng nhập từ khóa để tìm kiếm.');
    }

    // Tìm kiếm dữ liệu trong bảng `products` theo tên
    $results = \App\Models\Product::where('name', 'like', '%' . $query . '%')->get();

    // Gửi kèm dữ liệu đến view
    return view('admin.search-results', compact('results', 'query'));
}

}

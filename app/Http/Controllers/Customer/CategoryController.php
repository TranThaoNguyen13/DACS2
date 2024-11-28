<?php

namespace App\Http\Controllers\Customer;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Lấy tất cả danh mục từ cơ sở dữ liệu
        $categories = Category::all();
        // Trả về view và truyền biến categories
        return view('customer.home', compact('categories'));
    }
}


<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;




class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all(); // Lấy tất cả danh mục
        $brands = Brand::all(); 
        
        $bestSellers = Product::orderBy('sold', 'desc')->limit(10)->get();
        return view('customer.home', compact('categories', 'brands', 'bestSellers')); // Truyền biến vào view
    }
    public function search(Request $request)
{
    $search = $request->input('search');

    // Tìm kiếm trong các trường dữ liệu cần tìm
    // Ví dụ: tìm trong bảng `products`, bạn có thể tìm theo tên sản phẩm hoặc mô tả sản phẩm.
    $products = Product::where('name', 'like', '%'.$search.'%')
                       ->orWhere('description', 'like', '%'.$search.'%')
                       ->get();

    // Trả về kết quả tìm kiếm, ví dụ là các sản phẩm
    return view('customer.home', compact('products', 'search'));
}

}

    
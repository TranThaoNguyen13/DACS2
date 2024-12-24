<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');
        
        if ($search) {
            // Tìm kiếm sản phẩm trong cơ sở dữ liệu
            $results = Product::where('name', 'like', '%' . $search . '%')->get();
        } else {
            $results = collect(); // Nếu không có từ khóa tìm kiếm, trả về một collection rỗng
        }
    
        return view('customer.home', compact('results', 'search'));
    }
    
}

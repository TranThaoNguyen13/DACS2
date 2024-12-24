<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        // Share categories và brands với tất cả các views
        $categories = Category::all();
        $brands = Brand::all();
        view()->share([
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function index()
    {
        $products = Product::paginate(12);
        $bestSellers = Product::orderBy('sold', 'desc')->take(8)->get();
        $newProducts = Product::latest()->take(8)->get();
        
        return view('customer.home', compact('products', 'bestSellers', 'newProducts'));
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        
        // Tìm kiếm sản phẩm
        $products = Product::where(function($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
              ->orWhere('description', 'LIKE', "%{$query}%")
              ->orWhereHas('category', function($q) use ($query) {
                  $q->where('name', 'LIKE', "%{$query}%");
              });
        })->paginate(12);

        return view('products.index', [
            'products' => $products,
            'category' => (object)['name' => 'Kết quả tìm kiếm: ' . $query],
            'query' => $query
        ]);
    }

    public function getProductsByCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $products = $category->products;
        
        // Kiểm tra nếu không có sản phẩm trong danh mục
        if ($products->isEmpty()) {
            $products = null;
        }
        
        return view('customer.products', compact('products', 'category'));
    }

    public function getProductsByBrand($brandId)
    {
        $brand = Brand::findOrFail($brandId);
        $products = Product::where('brand_id', $brandId)->get();
        
        // Kiểm tra nếu không có sản phẩm trong thương hiệu
        if ($products->isEmpty()) {
            $products = null;
        }
        
        return view('customer.products', compact('products', 'brand'));
    }
}

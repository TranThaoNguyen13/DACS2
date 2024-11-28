<?php


namespace App\Http\Controllers\Customer;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    // Hiển thị danh sách các thương hiệu
    public function index()
    {
        $brands = Brand::all(); // Lấy tất cả các thương hiệu
        return view('brands.index', compact('brands'));
    }

    // Hiển thị sản phẩm theo thương hiệu
    public function showByBrand($brand)
    {
        // Lấy thương hiệu theo tên
        $brand = Brand::where('name', $brand)->firstOrFail();

        // Lấy các sản phẩm thuộc thương hiệu này
        $products = Product::where('brand_id', $brand->id)->get();

        return view('products.index', compact('products', 'brand'));
    }
}


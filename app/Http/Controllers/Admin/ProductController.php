<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;

class ProductController extends Controller
{
    public function index()
{
    $products = Product::all(); // Đảm bảo có bản ghi trong bảng products
    return view('admin.products.index', compact('products'));
}
   
    

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        // Kiểm tra tính hợp lệ của dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'new_price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'brand_id' => 'required|integer',
            'category_id' => 'required|integer',
            'sold' => 'nullable|integer'
        ]);

        // Khởi tạo sản phẩm mới
        $product = new Product();
        $product->name = $request->name;
        $product->new_price = $request->new_price;
        $product->old_price = $request->old_price;
        $product->description = $request->description;
        $product->brand_id = $request->brand_id;
        $product->category_id = $request->category_id;
        $product->sold = $request->sold ?? 0;

        // Xử lý upload ảnh
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        // Chuyển hướng về trang danh sách sản phẩm với thông báo thành công
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được thêm thành công!');
    }



    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu đầu vào nếu cần thiết
        $request->validate([
            'name' => 'required|string|max:255',
            'new_price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        // Tìm sản phẩm cần cập nhật
        $product = Product::findOrFail($id);
    
        // Cập nhật các trường dữ liệu
        $product->name = $request->input('name');
        $product->new_price = $request->input('new_price');
        $product->old_price = $request->input('old_price', null); // Để null nếu không có giá cũ
        $product->description = $request->input('description');
        $product->brand_id = $request->input('brand_id');
        $product->category_id = $request->input('category_id');
    
        // Kiểm tra và cập nhật hình ảnh nếu có
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $imageName);
            $product->image = $imageName;
        }
    
        // Lưu thay đổi
        $product->save();
    
        // Quay lại trang danh sách sản phẩm hoặc trang chi tiết sản phẩm
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }
    

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.index');
    }
}

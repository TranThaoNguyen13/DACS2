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
            // Lấy ảnh từ request
            $image = $request->file('image');
            
            // Tạo tên cho ảnh mới, ví dụ sử dụng timestamp để đảm bảo tên file duy nhất
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            
            // Di chuyển ảnh vào thư mục public/images
            $image->move(public_path('images'), $imageName);
            
            // Lưu đường dẫn vào cơ sở dữ liệu (public/images/tên_ảnh)
            $product->image = $imageName;
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
            $image->move(public_path('images'), $imageName);
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
    public function search(Request $request)
{
    // Lấy giá trị tìm kiếm từ form
    $query = $request->input('query');
    
    // Kiểm tra xem query có rỗng không
    if (empty($query)) {
        return redirect()->route('admin.products.index')->with('error', 'Vui lòng nhập từ khóa tìm kiếm.');
    }

    // Tìm kiếm sản phẩm theo tên, mô tả, danh mục, hoặc thương hiệu
    $products = Product::where('name', 'LIKE', "%{$query}%")
        ->orWhere('description', 'LIKE', "%{$query}%")
        ->orWhereHas('category', function ($queryBuilder) use ($query) {
            $queryBuilder->where('name', 'LIKE', "%{$query}%");
        })
        ->orWhereHas('brand', function ($queryBuilder) use ($query) {
            $queryBuilder->where('name', 'LIKE', "%{$query}%");
        })
        ->get();

    // Trả về kết quả tìm kiếm cho view
    return view('admin.products.index', compact('products'));
}

public function show($id)
{
    $product = Product::find($id);

    if (!$product) {
        return redirect()->route('admin.products.index')->with('error', 'Sản phẩm không tồn tại.');
    }

    return view('admin.products.index', compact('products'));
}

}

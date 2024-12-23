<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request)
{
    // Lấy từ khóa tìm kiếm từ form
    $query = $request->input('query');
    
    // Kiểm tra xem có từ khóa tìm kiếm không
    if ($query) {
        // Tìm kiếm thương hiệu theo tên
        $brands = Brand::where('name', 'LIKE', "%{$query}%")->get();
    } else {
        // Nếu không có tìm kiếm, hiển thị tất cả
        $brands = Brand::all();
    }

    return view('admin.brands.index', compact('brands'));
}


    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Kiểm tra loại file hình ảnh
    ]);

    $brand = new Brand();
    $brand->name = $request->name;

    // Kiểm tra xem có hình ảnh không
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images'), $filename); // Di chuyển ảnh vào thư mục public/images
        $brand->image = $filename; // Lưu đường dẫn hình ảnh vào cơ sở dữ liệu
    } else {
        $brand->image = 'images/default.jpg'; // Nếu không có ảnh, sử dụng ảnh mặc định
    }

    $brand->save(); // Lưu thông tin thương hiệu vào cơ sở dữ liệu

    return redirect()->route('admin.brands.index')->with('success', 'Thêm thương hiệu thành công!');
}



    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
    
        // Kiểm tra xem có ảnh mới không
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename); // Di chuyển ảnh vào thư mục public/images
            $brand->image = $filename; // Lưu đường dẫn hình ảnh vào cơ sở dữ liệu
        }
    
        $brand->save(); // Lưu thông tin thương hiệu vào cơ sở dữ liệu
    
        return redirect()->route('admin.brands.index')->with('success', 'Thương hiệu đã được cập nhật.');
    }
    

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
$brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'Thương hiệu đã được xóa.');
    }
}
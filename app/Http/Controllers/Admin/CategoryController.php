<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        if ($query) {
            // Tìm kiếm thương hiệu theo tên
            $categories = Category::where('name', 'LIKE', "%{$query}%")->get();
        } else {
            // Nếu không có tìm kiếm, hiển thị tất cả
            $categories = Category::all();
        }
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }
    public function show($id) {
        $category = Category::findOrFail($id);
        return view('admin.categories.show', compact('category'));
    }
    public function store(Request $request)
{
    // 1. Xác thực dữ liệu
    $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // 2. Tạo một đối tượng Category mới
    $category = new Category;
    $category->name = $request->name;

    // 3. Xử lý file hình ảnh
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName(); // Tạo tên ảnh duy nhất
        $image->move(public_path('images'), $imageName); // Lưu ảnh vào thư mục public/images
        $category->image = $imageName; // Lưu đường dẫn ảnh vào database
    }

    // 4. Lưu danh mục vào cơ sở dữ liệu
    $category->save();

    // 5. Chuyển hướng về danh sách danh mục với thông báo thành công
    return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được thêm thành công!');
}

    

    

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate hình ảnh nếu có
        ]);
    
        $category = Category::findOrFail($id);
        $category->name = $request->name;
    
        // Kiểm tra và lưu hình ảnh mới (nếu có)
        if ($request->hasFile('image')) {
            // Xóa hình ảnh cũ nếu có
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }
    
            // Lưu hình ảnh mới
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName(); // Tạo tên ảnh duy nhất
            $image->move(public_path('images'), $imageName); // Lưu vào thư mục public/images
            $category->image = $imageName; // Cập nhật đường dẫn vào database
        }
    
        $category->save();
    
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được cập nhật.');
    }
    

    public function destroy($id)
{
    $category = Category::findOrFail($id);

    // Xóa file hình ảnh nếu có
    if ($category->image && file_exists(public_path($category->image))) {
        unlink(public_path($category->image));
    }

    $category->delete();

    return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được xóa.');
}

    
}

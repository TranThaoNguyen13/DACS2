<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
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
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $category = new Category;
    $category->name = $request->name;
    $category->description = $request->description;
    // Nếu có trường hình ảnh, bạn có thể lưu lại như thế này:
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('images', 'public');
        $category->image = $path;
    }
    $category->save();

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
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được cập nhật.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được xóa.');
    }
}

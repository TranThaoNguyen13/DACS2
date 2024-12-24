<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    // Hiển thị danh sách cửa hàng
    public function index(Request $request)
    {
        // Kiểm tra nếu có truy vấn tìm kiếm
        $query = $request->input('query');
        
        if ($query) {
            // Tìm kiếm cửa hàng theo tên hoặc địa chỉ
            $stores = Store::where('name', 'like', "%{$query}%")
                ->orWhere('address', 'like', "%{$query}%")
                ->get();
        } else {
            // Lấy tất cả cửa hàng nếu không có truy vấn
            $stores = Store::all();
        }

        return view('admin.stores.index', compact('stores'));
    }

    // Hiển thị form thêm cửa hàng
    public function create()
    {
        return view('admin.stores.create');
    }

    // Lưu cửa hàng mới
    public function store(Request $request)
    {
        // Validating dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'map_url' => 'nullable|url',
        ]);

        // Tạo cửa hàng mới
        Store::create([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'map_url' => $request->input('map_url'),
        ]);

        return redirect()->route('admin.stores.index')->with('success', 'Cửa hàng đã được thêm thành công.');
    }

    // Hiển thị form chỉnh sửa cửa hàng
    public function edit($id)
    {
        $store = Store::findOrFail($id);
        return view('admin.stores.edit', compact('store'));
    }

    // Cập nhật thông tin cửa hàng
    public function update(Request $request, $id)
    {
        $store = Store::findOrFail($id);

        // Validating dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'map_url' => 'nullable|url',
        ]);

        // Cập nhật cửa hàng
        $store->update([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'map_url' => $request->input('map_url'),
        ]);

        return redirect()->route('admin.stores.index')->with('success', 'Cửa hàng đã được cập nhật thành công.');
    }

    // Xóa cửa hàng
    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();

        return redirect()->route('admin.stores.index')->with('success', 'Cửa hàng đã được xóa thành công.');
    }
}

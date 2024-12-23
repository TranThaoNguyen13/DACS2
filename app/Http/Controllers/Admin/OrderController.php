<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng
    public function index()
    {
        // Lấy tất cả đơn hàng từ cơ sở dữ liệu
        $orders = Order::all();
        return view('admin.orders.index', compact('orders'));
    }

    // Hiển thị form chỉnh sửa đơn hàng
    public function edit($id)
    {
        // Tìm đơn hàng theo id
        $order = Order::findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    // Cập nhật thông tin đơn hàng
    public function update(Request $request, $id)
    {
        // Tìm đơn hàng theo id
        $order = Order::findOrFail($id);

        // Validate dữ liệu
        $request->validate([
            'status' => 'required|in:Chờ xác nhận,Đã xác nhận,Đang vận chuyển,Đã vận chuyển,Đã nhận,Trả đơn/Hoàn hàng,Đã huỷ',
        ]);

        // Cập nhật trạng thái đơn hàng
        $order->status = $request->input('status');
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được cập nhật!');
    }

    // Xóa đơn hàng
    public function destroy($id)
    {
        // Tìm và xóa đơn hàng theo id
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được xóa!');
    }
    public function search(Request $request)
{
    // Lấy từ khóa tìm kiếm
    $query = $request->input('query');
    
    // Tìm kiếm đơn hàng theo các trường 'username', 'status', 'user_id'
    $orders = Order::where('username', 'like', '%' . $query . '%')
                    ->orWhere('status', 'like', '%' . $query . '%')
                    ->orWhere('user_id', 'like', '%' . $query . '%')
                    ->get();
    
    // Trả về view với kết quả tìm kiếm
    return view('admin.orders.index', compact('orders', 'query'));
}

    
}
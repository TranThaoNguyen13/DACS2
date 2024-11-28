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
            'status' => 'required|in:pending,processed,shipped,delivered,canceled',
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
}
